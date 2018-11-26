<?php

namespace App\Http\Controllers;

use App\Http\Model\User;
use App\Http\Model\Member;
use App\Http\Model\Life;
use App\Http\Model\Chapter;
use App\Http\Model\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XeroPHP\Application\PrivateApplication;
use Illuminate\Support\Facades\Log;
use XeroPHP\Models\Accounting\Contact;
use XeroPHP\Models\Accounting\Invoice;
use Illuminate\Support\Facades\DB;
use PDF;

class AdminController extends Controller
{


public function chapter_view()
{
    $chapters = DB::table('chapter')
    ->paginate(500);

    return view('admin_page/chapter',compact('chapters'));
}

public function getChapterDetails(Chapter $chapter)
{
    return json_encode(array('result' => 'success', 'data' => $chapter));
}


public function life_view(Request $request)
{
    $life;
    if ($request->search_life_no != '')
    {
        $life_no = strtoupper(trim($request->search_life_no));
        $life =  DB::table('life')
        ->where('life_no','like','%'.$life_no.'%')
        ->paginate(50);
    } else if ($request->search_ln_fn != '') {
        $ln_fn = strtoupper(trim($request->search_ln_fn));
        $life =  DB::table('life')
        ->where('name','like','%'.$ln_fn.'%')
        ->paginate(50);
    } else {
        $life = DB::table('life')
        ->paginate(50);
    }

    return view('admin_page/life',compact('life'));
}

public function bluecards_view()
{
    $blue_card = DB::table('blue_card')
    ->paginate(30);

    return view('admin_page/bluecards',compact('blue_card'));
}

public function viewStatement($snum){
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
            $pdf = PDF::loadView('admin_page/statement',compact('statement_data','sur','given','middle','chapter','compute_total')); 
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
            $pdf = PDF::loadView('admin_page/statement',compact('statement_data','sur','given','middle','chapter','compute_total')); 
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
            $pdf = PDF::loadView('admin_page/statement',compact('statement_data','sur','given','middle','chapter','compute_total'));  
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
            $pdf = PDF::loadView('admin_page/statement',compact('statement_data','sur','given','middle','chapter','compute_total')); 
            return $pdf->stream('document.pdf');
        }  

    }
       
    return 'failed';
}

}

