<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Member;
use App\Http\Model\User;
use Mail;
use Validator;
use URL;


class RegistrationController extends Controller
{

    protected function registration(Request $request)
    {
        return view('admin_page.registration');    
    }

    protected function resyncAccount($prc_no)
    {
        $result = DB::table('membership')->selectRaw('prc_no, count(prc_no) mem_count')
        ->where('prc_no',$prc_no)
        ->where('is_deleted',0)
        ->groupBy('prc_no')->first();
        
        $mem_count = 0;
        $count = null;

        if ($result)
        {
            $mem_count = $result->mem_count;

             $count = User::where('prc_no',$prc_no)->update([                
                'mem_count' => $mem_count,
            ]);

        }

        if ($count)
        {
            return json_encode(array('result' => 'success', 'message' => 'Record Updated'));
        } else {
            return json_encode(array('result' => 'failed', 'message' => 'No Record Updated'));
        }

    }

    protected function deleteAccount($prc_no)
    {
       
        $count = 0;

        if ($prc_no)
        {
            $count = User::where('prc_no',$prc_no)->delete();
        }

        if ($count > 0)
        {
            return json_encode(array('result' => 'success', 'message' => 'User Deleted'));
        } else {
            return json_encode(array('result' => 'failed', 'message' => 'No Record Updated'));
        }

    }

    protected function getUnverifiedAccount()
    {
        $singledata = DB::table('users')->selectRaw('users.prc_no, users.given ugiven, membership.given mgiven, users.sur usur, membership.sur msur, mem_count, verify_token')
        ->leftJoin('membership','users.prc_no','=','membership.prc_no')
        ->where('is_deleted',0)
        ->where('verified',0)
        ->where('mem_count',1)
        ->get();

        
        $dupdata = DB::table('users')->selectRaw('users.prc_no, users.given ugiven, tmp.given mgiven, users.sur usur, tmp.sur msur, mem_count')
        ->join(DB::raw('(select prc_no, given, sur from membership where is_deleted = 0 group by prc_no, given, sur having count(prc_no) > 1) tmp'),'users.prc_no','=','tmp.prc_no')
        ->where('verified',0)
        ->where('mem_count','>',1)
        ->whereNull('verify_token')
        ->get();

        $newdata = DB::table('users')->selectRaw('users.prc_no, users.given ugiven, users.sur usur, "" msur , "" mgiven,  (select count(given) from membership where membership.given 
        like users.given and membership.sur like users.sur 
        and is_deleted = 0 and prc_no = 0) match_name, verify_token ')        
        ->where('mem_count',0)
        ->where('verified',0)
        ->get();
        
        $data = $singledata->merge($newdata)->merge($dupdata);

        return json_encode(array('result' => 'success', 'data' => $data));
    }

    protected function verifyAccount($prc_no)
    {
        $user = User::select('given','middle','sur','email','prc_no', 'mem_count')->where('prc_no',$prc_no)->whereNull('verify_token')->first();
        $member = null;
        if ($user)
        {
            
            if ($user['mem_count'] > 1)
            {
                return json_encode(array('result' => 'failed', 'message' => 'Associated Existing Member Record has Duplicate. Please remove duplicate record and perform Resync.' ));
            }
            
            $token = uniqid('mem',true);
            User::where('prc_no',$prc_no)->update([                
                'verify_token' => $token
            ]);

            $member = Member::select('prc_no')->where('prc_no',$prc_no)->first();

            if (!$member)    
            {
                $currentYear = date('Y');
                $newMember = Member::create([
                    'prc_no'=>strtoupper($user['prc_no']),
                    'given'=>strtoupper($user['given']),
                    'sur'=>strtoupper($user['sur']),
                    'e_mail'=>$user['email'],
                    'year'=>$currentYear,
                    'mem_not_paid'=>0,
                    'middlename'=>strtoupper($user['middle']),
                    'middle'=>$user['middle']==''?'':strtoupper(substr($user['middle'],0,1)),
                ]);

           		$newMember->snum = $newMember->id;
                $newMember->save();    
                $member = $newMember;         
            }

            $user['verify_token'] = $token;
            $user['url'] = URL::to('/');
            $subject = 'PICE Membership Account Verification';
            Mail::send('emails.verify_user', ['user' => $user], function ($message) use ($user, $subject) {
                $message->from('administration@pice.org.ph', 'PICE Membership Head')->subject($subject);
                $emails = [$user['email']];
                $message->to($emails)->subject($subject);            
            });      
        } 
        return json_encode(array('result' => 'success', 'data' => $user, 'member' => $member ));
    }

}