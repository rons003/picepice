<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Member;
use App\Http\Util\PaymentUtil;
use App\Http\Util\HttpUtil;


use PDF;


class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('member');
        
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        return view('members_page/membership');
    }

    public function loadMap()
    {

        return view('members_page/map');
    }


    public function getMemberInfo()
    {
        $user_info = json_decode(Auth::user(),true);

        $member_info = DB::table('membership')
        ->leftJoin('chapter', 'membership.chap_code', '=', 'chapter.chap_code')
        ->where('membership.prc_no', $user_info['prc_no'])
        ->get();
        return json_encode(array('result' => 'success', 'data' => $member_info));
    }

    public function invoices_view()
    {
        $user_info = json_decode(Auth::user(),true);

        $getXero = DB::table('membership')
        ->select('xero_id')
        ->where('prc_no', $user_info['prc_no'])
        ->get();

        $xero_id = json_decode($getXero,true);

        $invoice = DB::table('invoice')
        ->where('contactid', $xero_id[0]['xero_id'])
        ->paginate(10);

        return view('members_page.members_invoice',compact('invoice'));
    }

    public function account_view()
    {

        return view('members_page.account');
    }

    public function payments_view()
    {
        $user_info = json_decode(Auth::user(),true);
        
        /*
        $memberPayment = PaymentUtil::generateMemberPayables(2018,2001,150,200,150);
                        
        foreach ($memberPayment->paymentLineItems as $paymentLineItem) {
            \Log::debug('CCPLI '. $paymentLineItem->lastpayyearrange);
        }*/
        
        $getSnum = DB::table('membership')
        ->select('snum')
        ->where('prc_no', $user_info['prc_no'])
        ->get();

        foreach ($getSnum as $o){
            $payments = DB::table('payment')
            ->where('snum', $o->snum)
            //->where('status','!=','7')
            ->paginate(10);
            return view('members_page.payments',compact('payments'));
        }
        
        
    }

    public function viewStatement(Request $request){
        $user_info = json_decode(Auth::user(),true);  
        $member_payment = null;      
        $mem_info = DB::table('membership')
        ->select('snum','last_pay','sur','given','middle','chap_code')
        ->where('prc_no', $user_info['prc_no'])
        ->first();
        $last_pay = $mem_info->last_pay<=1996?1996:$mem_info->last_pay;
        if ($last_pay >= 2018)
        {
         
        } else
        {
           $member_payment = PaymentUtil::generateMemberPayables(2018,$last_pay,150,200,150);
        }
        return view('members_page.statement',compact('member_payment','mem_info','chapter'));

    }

    public function viewStatementPdf(){
        $user_info = json_decode(Auth::user(),true);
        $snum;
        $getSnum = DB::table('membership')
        ->select('snum')
        ->where('prc_no', $user_info['prc_no'])
        ->get();

        foreach ($getSnum as $o){
            $snum = $o->snum;
        }

        $statement_data;
        $pdf;
        $statement = DB::table('payment')
        ->leftJoin('chapter','payment.chap_code', '=' ,'chapter.chap_code')
        ->leftJoin('membership', 'payment.snum', '=', 'membership.snum')
        ->selectRaw("
            payment.chap_code,
            DATE_FORMAT(STR_TO_DATE(payment.last_pay, '%d/%m/%Y'), '%Y'),
            chapter.chap_dues,
            chapter.natl_dues,
            chapter.chapter,
            membership.sur,
            membership.given,
            membership.middle,
            membership.cell_no,
            membership.tel_fax
            ")
        ->where('payment.snum','=',$snum)
        ->orderBy('payment.id', 'desc')
        ->limit(1)
        ->get();
    //$pdf = PDF::loadView('admin_page/statement',compact('statement_data')); 
        foreach ($statement as $value){
            $chap_code = $value->chap_code;
            $lastpayyear = $value->{"DATE_FORMAT(STR_TO_DATE(payment.last_pay, '%d/%m/%Y'), '%Y')"};
            $chap_dues = $value->chap_dues;
            $natl_dues = $value->natl_dues;
            $chapter = $value->chapter;
            $sur = $value->sur;
            $given = $value->given;
            $middle = $value->middle;
            if($lastpayyear <= 2001){
                $statement_data = [
                    'lastpay' => $lastpayyear,
                    'data1' => [
                        'lastpayyear' => $lastpayyear,
                        'total_chap_dues' => $chap_dues * .20 *(2001- $lastpayyear),
                        'total_natl_dues' => ($natl_dues * .20) * (2001 - $lastpayyear),
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues * .20 *(2001- $lastpayyear) + ($natl_dues * .20) * (2001 - $lastpayyear)
                    ],
                    'data2' => [
                        'total_chap_dues' => $chap_dues,
                        'total_natl_dues' => $natl_dues,
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues + $natl_dues
                    ],
                    'data3' => [
                        'total_chap_dues' => $chap_dues * .50 *(2010 - 2002),
                        'total_natl_dues' => $natl_dues * (2010 - 2002),
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues * .50 *(2010 - 2002) + $natl_dues * (2010 - 2002)
                    ],
                    'data4' => [
                        'total_chap_dues' => $chap_dues *(2018- 2010),
                        'total_natl_dues' => 250 * (2018 - 2010),
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues * (2018- 2010) + 250 * (2018 - 2010)
                    ]
                ];
                $compute_total = $statement_data['data1']['amount'] + $statement_data['data2']['amount'] + $statement_data['data3']['amount'] + $statement_data['data4']['amount'] ;
                $pdf = PDF::loadView('members_page/statementpdf',compact('statement_data','sur','given','middle','chapter','compute_total')); 
                return $pdf->stream('document.pdf');
            } 

            else if($lastpayyear <= 2002){
                $statement_data = [
                    'lastpay' => $lastpayyear,
                    'data2' => [
                        'total_chap_dues' => $chap_dues,
                        'total_natl_dues' => $natl_dues,
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues + $natl_dues
                    ],
                    'data3' => [
                        'total_chap_dues' => $chap_dues * .50 *(2010 - 2002),
                        'total_natl_dues' => $natl_dues * (2010 - 2002),
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues * .50 *(2010 - 2002) + $natl_dues * (2010 - 2002)
                    ],
                    'data4' => [
                        'total_chap_dues' => $chap_dues *(2018- 2010),
                        'total_natl_dues' => 250 * (2018 - 2010),
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues * (2018- 2010) + 250 * (2018 - 2010)
                    ]
                ];
                $compute_total = $statement_data['data2']['amount'] + $statement_data['data3']['amount'] + $statement_data['data4']['amount'] ;
                $pdf = PDF::loadView('members_page/statementpdf',compact('statement_data','sur','given','middle','chapter','compute_total')); 
                return $pdf->stream('document.pdf');
            } 

            else if($lastpayyear <= 2003 || 2010 >= $lastpayyear){
                $statement_data = [
                    'lastpay' => $lastpayyear,
                    'data3' => [
                        'total_chap_dues' => $chap_dues * .50 *(2010 - $lastpayyear),
                        'total_natl_dues' => $natl_dues * (2010 - 2002),
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues * .50 *(2010 - $lastpayyear) + $natl_dues * (2010 - $lastpayyear)
                    ],
                    'data4' => [
                        'total_chap_dues' => $chap_dues *(2018- 2010),
                        'total_natl_dues' => 250 * (2018 - 2010),
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues * (2018- 2010) + 250 * (2018 - 2010)
                    ]

                ];
                $compute_total = $statement_data['data3']['amount'] + $statement_data['data4']['amount'] ;
                $pdf = PDF::loadView('members_page/statementpdf',compact('statement_data','sur','given','middle','chapter','compute_total')); 
                return $pdf->stream('document.pdf');
            }

            else if($lastpayyear <= 2011 || 2018 >= $lastpayyear){
                $statement_data = [
                    'lastpay' => $lastpayyear,
                    'data4' => [
                        'total_chap_dues' => $chap_dues *(2018- $lastpayyear),
                        'total_natl_dues' => 250 * (2018 - $lastpayyear),
                        'chap_dues' => $chap_dues,
                        'natl_dues' => $natl_dues,
                        'amount' => $chap_dues * (2018- $lastpayyear) + 250 * (2018 - $lastpayyear)
                    ]
                ];
                $compute_total = $statement_data['data4']['amount'] ;
                $pdf = PDF::loadView('members_page/statementpdf',compact('statement_data','sur','given','middle','chapter','compute_total')); 
                return $pdf->stream('document.pdf');
            }  

        }
    }

    public function updateProfile(Request $request)
    {
        $id;
        $user_info = json_decode(Auth::user(),true);

        $member_info = DB::table('membership')
        ->select('id')
        ->where('prc_no', $user_info['prc_no'])
        ->get();

        foreach ($member_info as $o){
            $id = $o->id;
        }

        $updateMember = Member::where('id', $id)->update($request->except('_token'));

        if($updateMember){
            return json_encode(array('result' => 'success', 'message' => 'Profile successfully updated.'));
        }

        return json_encode(array('result' => 'error', 'message' => 'There\'s an error encountered while saving'));
    }

    public function chapter_view()
    {
        return view('members_page.chapter');
    }
    public function landing_view()
    {
        return view('members_page.landing');
    }
    
    public function events_view()
    {
     return view('members_page.events');
    }

    public function getEvents()
    {
        return HttpUtil::getExternalHttpResponse();
    }

    
}
