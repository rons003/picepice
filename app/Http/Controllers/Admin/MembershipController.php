<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XeroPHP\Application\PrivateApplication;
use Illuminate\Support\Facades\Log;
use XeroPHP\Models\Accounting\Contact;
use XeroPHP\Models\Accounting\Invoice;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Member;
use Validator;


class MembershipController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request){
		return view('admin_page/home');
	}

	public function createMember(Request $request){
		$validation = Validator::make($request->all(), [            
            'mem_code' => 'required',
            'date_mem' => 'required',
            'chap_code' => 'required',
            'given' => 'required',
            'sur' => 'required',
			'middlename' => 'required',
			'gender' => 'required',
			'prc_no' => 'required|unique:membership|min:1',
            'civilstat' => 'required'
        ]);

		if ($validation->fails())
        {
            return json_encode([
            	'result' => 'failed', 
            	'message' => 'Invalid Data Detected. Please try again. ',
            	'error' => $validation->errors()->all()
            ]);

        }

		/*
		$max = DB::table('membership')
                ->selectRaw('max(`id`) as id')
                ->get();

        foreach($max as $o){
        	$request['snum'] = $o->id + 1;
        }*/

		$newMember = Member::create($request->all());
		$newMember->snum = $newMember->id;
		$newMember->save();

		if($newMember){
			return json_encode(array('result' => 'success', 'message' => 'Successfully Added'));
		}
	}


	public function getMemberAll(Request $request){
		$members;
		$membersSelect = DB::table('membership')
		->select(
			'id',
			'mem_code',
			'prc_no',
			'sur',
			'given',
			'middlename',
			'xero_id',
			'snum',
			'life_no',
			'associate'
		);

		if ($request['search_ln_fn'] != '')
		{
			$name = strtoupper(trim($request['search_ln_fn']));
			$members =  $membersSelect
			->where('given','like',$name.'%')
			->where('is_deleted',0)
			->orWhere('sur','like',$name.'%')
			->where('is_deleted',0)
			->orderBy('prc_no', 'asc')
			->orderBy('sur', 'asc')
			->orderBy('given', 'asc')
			->paginate(100);
		} else if ($request['search_prc_no'] != ''){
			$prc_no = strtoupper(trim($request['search_prc_no']));
			$members =  $membersSelect
			->where('prc_no',$prc_no)
			->where('is_deleted',0)
			->orderBy('prc_no', 'asc')
			->orderBy('sur', 'asc')
			->orderBy('given', 'asc')
			->paginate(100);
		} else if ($request['req_given'] != ''){
			$given = strtoupper(trim($request['req_given']));
			$sur = strtoupper(trim($request['req_sur']));
			$members =  $membersSelect
			->where('given',$given)
			->where('sur',$sur)
			->where('is_deleted',0)
			->orderBy('prc_no', 'asc')
			->orderBy('sur', 'asc')
			->orderBy('given', 'asc')
			->paginate(100);
		} else {
			$members =  $membersSelect
			->where('is_deleted',0)
			->orderBy('prc_no', 'asc')
			->orderBy('sur', 'asc')
			->orderBy('given', 'asc')
			->paginate(100);

		}

		return json_encode(array('result' => 'success', 'data' => $members));
	}

	public function getMemberInfo(Member $member){
		return json_encode(array('result' => 'success', 'data' => $member));
	}

	public function getDeletedMember(){
		$delete_members =  DB::table('membership')
		->select(
			'id',
			'prc_no',
			'sur',
			'given',
			'middlename'

		)
		->where('is_deleted',1)
		->paginate();
		return json_encode(array('result' => 'success', 'data' => $delete_members));
	}

	public function updateMember($id,Request $request){
		$validation = Validator::make($request->all(), [
            'prc_no' => 'required',
            'date_mem' => 'required',
            'chap_code' => 'required',
            'given' => 'required',
            'sur' => 'required',
            'middlename' => 'required',
            'gender' => 'required',
			'civilstat' => 'required',
			'type_mem' => 'required'
        ]);

		if ($validation->fails())
        {
            return json_encode([
            	'result' => 'failed', 
            	'message' => 'Invalid Data Detected. Please try again. ',
            	'error' => $validation->errors()->all()
            ]);

        }

		$updateMember = Member::where('id', $id)->update($request->except('_token'));

		if($updateMember){
			return json_encode(array('result' => 'success', 'message' => 'Member successfully updated.'));
		}

		return json_encode(array('result' => 'error', 'message' => 'There\'s an error encountered while saving'));
	}

	public function deleteMember(Request $request){
		$member_id_array = $request->input('id');
		$delete_member = Member::whereIn('id', $member_id_array)->update(['is_deleted' => 1]);
		if($delete_member){
			return json_encode(array('result' => 'success', 'message' => 'Member successfully deleted.'));
		}
	}

	public function restoreMember($id){
		$restoreMember = Member::where('id', $id)->update(['is_deleted' => 0]);

		if($restoreMember){
			return json_encode(array('result' => 'success', 'message' => 'Member successfully restored.'));
		}

		return json_encode(array('result' => 'error', 'message' => 'There\'s an error encountered while saving'));
	}

	public function getChapters(){
		$chapter = DB::table('chapter')
			->select(
				'chap_code',
				'chapter'
			)
			->get();
		return json_encode(array('result' => 'success', 'chapter' => $chapter));
	}

}