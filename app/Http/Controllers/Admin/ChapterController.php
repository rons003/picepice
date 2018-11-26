<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Model\Chapter;
use App\Http\Model\Member;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Validator;
use PDF;

class ChapterController extends Controller
{
	public function index(){
		$chapters = DB::table('chapter')
    		->paginate(500);
    		
		return view('admin_page/chapter',compact('chapters'));
	}

	public function createChapter(Request $request){
		$validation = Validator::make($request->all(), [
            'chap_code' => 'required',
			'chapter' => 'required',
			'chap_dues' => 'required',
			'natl_dues' => 'required',
			'establishe' => 'required',
			'reptype' => 'required',
			'region' => 'required'
        ]);

		if ($validation->fails())
        {
            return json_encode([
            	'result' => 'failed', 
            	'message' => 'Invalid Data Detected. Please try again. ',
            	'error' => $validation->errors()->all()
            ]);

		}

		$newChapter = Chapter::create($request->all());

		if($newChapter){
			return json_encode(array('result' => 'success', 'message' => 'Successfully Added!'));
		}
	}

	public function getChapter(Chapter $chapter){
		return json_encode([
			'result' => 'success',
			'chapter' => $chapter
		]);
	}

	public function getChapterReport(Chapter $chapter) {			
		$chapterMembers = Member::select('given','sur', 'middle', 'last_pay', 'year', 'yr_code','chap_code','chap_no','mem_code','remarks')
		->where('chap_code',$chapter->chap_code)
		->get();
		$pdf = SnappyPdf::loadView('admin_page/chapter_report',compact('chapterMembers','chapter')); 
        return $pdf->stream('chapter_report.pdf');
	}

	public function getChapterReportOld(Chapter $chapter) {			
		$chapterMembers = Member::select('given','sur', 'middle', 'last_pay', 'year', 'yr_code','chap_code','chap_no','mem_code','last_pay_date','remarks')
		->where('chap_code',$chapter->chap_code)
		->get();
		$pdf = PDF::loadView('admin_page/chapter_report',compact('chapterMembers','chapter')); 
        return $pdf->stream('chapter_report.pdf');
	}

	public function updateChapter($id, Request $request){
		$validation = Validator::make($request->all(), [
            'chap_code' => 'required',
			'chapter' => 'required',
			'chap_dues' => 'required',
			'natl_dues' => 'required',
			'establishe' => 'required',
			'reptype' => 'required',
			'region' => 'required'
        ]);

		if ($validation->fails())
        {
            return json_encode([
            	'result' => 'failed', 
            	'message' => 'Invalid Data Detected. Please try again. ',
            	'error' => $validation->errors()->all()
            ]);

		}
		
		$updateChapter = Chapter::where('id', $id)->update($request->except('_token'));

		if($updateChapter){
			return json_encode(array('result' => 'success', 'message' => 'Chapter successfully updated.'));
		}

		return json_encode(array('result' => 'error', 'message' => 'There\'s an error encountered while saving'));
	}

	public function deleteChapter(Request $request){
		$chapter_id_array = $request->input('id');
		$delete_chapter = Chapter::where('id', $chapter_id_array)->delete();
		if($delete_chapter){
			return json_encode(array('result' => 'success', 'message' => 'Chapter successfully deleted.'));
		}
	}
}