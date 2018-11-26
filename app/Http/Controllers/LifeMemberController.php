<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Member;
use App\Http\Util\PaymentUtil;
use App\Http\Util\HttpUtil;


use PDF;


class LifeMemberController extends Controller
{

    public function viewLifeMember(Request $request)
    {
        $mem_info = Member::select('remarks', 'is_life_member', 'snum',DB::raw("DATE_FORMAT(STR_TO_DATE(membership.last_pay, '%a %b %j %T %Y'), '%Y') last_pay "),'sur','given',
                'middle','mem_not_paid','membership.year')
        ->where('prc_no', Auth::user()->prc_no)
        ->first();

        if ($mem_info->is_life_member)
        {
            return view('members_page.lifemember',compact('mem_info'));

        } else
        {
            return redirect('/member/dues');
        }
    
    }
}