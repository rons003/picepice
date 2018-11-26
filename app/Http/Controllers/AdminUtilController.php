<?php

namespace App\Http\Controllers;

use App\Http\Model\User;
use App\Http\Model\Member;
use App\Http\Model\Life;
use App\Http\Model\Chapter;
use App\Http\Model\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class AdminUtilController extends Controller
{

	public function getDuplicateMember(Request $request){
    $members;

    $membersSelect =  DB::table('membership')
        ->select(
            'id',
            'prc_no',
            'sur',
            'given',
            'middlename',
            'xero_id',
            'snum'
        );

    if ($request['search_ln_fn'] != '')
    {
        $name = strtoupper(trim($request['search_ln_fn']));
        $members = $membersSelect
        ->where('given','like','%'.$name.'%')
        ->orWhere('sur','like','%'.$name.'%')
        ->paginate(50);
    } else if ($request['search_prc_no'] != '')
    {
        $prc_no = strtoupper(trim($request['search_prc_no']));
        $members = $membersSelect
        ->where('prc_no','like','%'.$prc_no.'%')
        ->paginate(50);
    }  else {
        $members = $membersSelect
        ->paginate(50);
    }

    return json_encode(array('result' => 'success', 'data' => $members));
}


}