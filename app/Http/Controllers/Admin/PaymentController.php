<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Model\Payment;
use App\Http\Model\PaymentDetail;
use PDF;

use App\Http\Util\PaymentUtil;
use App\Http\Model\MembershipPayment;
use Validator;


class PaymentController extends Controller
{
	public function index(){
		return view('admin_page/create_payment');
	}

	public function getMemberSearch($key){
		$sur = strtoupper(trim($key));
		$member = DB::table('membership')
		->select(
			'prc_no',
			'sur',
			'given',
			'middle',
			'middlename',
			'snum',
			'life_no',
			'payables',
			'last_pay',
			'created_at'
		)
		->where('sur', 'like',$sur.'%')
		->where('is_deleted', 0)
		->paginate(10000);

		if($member){
			return json_encode([
				'result' => 'success',
				'data' => $member
			]);
		} else {
			return json_encode([
				'result' => 'Failed!',
				'message' => 'Something error..'
			]);
		}
	}

	public function statement($yearpaid,$snum){
		$statement = DB::table('payment')
		->leftJoin('membership', 'payment.snum', '=', 'membership.snum')
		->leftJoin('chapter','membership.chap_code', '=' ,'chapter.chap_code')
		->selectRaw("
			membership.chap_code,
			DATE_FORMAT(STR_TO_DATE(payment.last_pay, '%d/%m/%Y'), '%Y') AS 'yearpay',
			payment.payables,
			payment.remarks,
			chapter.chap_dues,
			chapter.natl_dues,
			chapter.chapter,
			membership.sur,
			membership.given,
			membership.middle,
			membership.cell_no,
			membership.tel_fax,
			membership.life_no,
			membership.yr_code,
			membership.year
			")
		->where('payment.snum','=',$snum)
		->orderBy('payment.id', 'desc')
		->limit(1)
		->get();
		if(count($statement) != 0){
			foreach ($statement as $value){
				$chap_code = $value->chap_code;
				$lastpayyear = $value->yearpay;
				$payables = $value->payables;
				$chap_dues = $value->chap_dues;
				$natl_dues = $value->natl_dues;
				$chapter = $value->chapter;
				$sur = $value->sur;
				$given = $value->given;
				$middle = $value->middle;
				$yearpayables;
				$arrears_year_start;
				$sum_total = 0;
				$date_mem = $value->year?$value->year:$value->yr_code;
				if($date_mem != null || $date_mem != ''){
					if($lastpayyear == ''){
						$arrears_year_start = $payables;
						$yearpayables = $payables;
					} else {
						$arrears_year_start = $lastpayyear + 1;
						$yearpayables = $lastpayyear + 1;
					}
	
					$r_instatementPenalty = date("Y") - $yearpayables;
					if($r_instatementPenalty >= 3){
						$r_instatementPenalty = 100;
					} else {
						$r_instatementPenalty = 0;
					}
	
					$statement_data = [];
					$final_total = $r_instatementPenalty * 2;
					$memberPayment = PaymentUtil::generateMemberPayables(
						$yearpaid,
						$yearpayables,
						$chap_dues,
						$natl_dues,
						0
					);
	
					foreach($memberPayment->paymentLineItems as $paymentLineItem){
						$data = array(
							'yearcovered' => $paymentLineItem->year,
							'total_chap_dues' => $paymentLineItem->net_total_chap_dues,
							'total_natl_dues' => $paymentLineItem->net_total_natl_dues,
							'total_amount' => $paymentLineItem->net_total_chap_dues + $paymentLineItem->net_total_natl_dues
						);
						$final_total += $paymentLineItem->net_total_chap_dues + $paymentLineItem->net_total_natl_dues;
						$statement_data[] = $data;
					}
					return json_encode([
						'result' => 'success',
						'yearpayables' => $yearpayables,
						'statement_data' => $statement_data,
						'statement' => $statement,
						'rstate' => $r_instatementPenalty,
						'total' => $final_total
					]);
				} else {
					return json_encode([
						'result' => 'failed',
						'message' => 'Update this Member Year of Membership'
					]);
				}
			}

		} else {
			$members_data = DB::table('membership')
			->leftJoin('chapter','membership.chap_code', '=', 'chapter.chap_code')
			->selectRaw("
				membership.sur,
				membership.given,
				membership.middle,
				membership.cell_no,
				membership.tel_fax,
				membership.life_no,
				membership.chap_code,
				membership.year,
				chapter.chap_dues,
				chapter.natl_dues,
				chapter.chapter
				")
			->where('membership.snum','=',$snum)
			->get();
			if(count($members_data) != 0){
				foreach ($members_data as $value){
					$chap_code = $value->chap_code;
					$year_code = $value->year;
					$chap_dues = $value->chap_dues;
					$natl_dues = $value->natl_dues;
					$chapter = $value->chapter;
					$sur = $value->sur;
					$given = $value->given;
					$middle = $value->middle;
					$yearpayables = $year_code;		

					if($year_code != null){
						
						$r_instatementPenalty = date("Y") - $yearpayables;
						if($r_instatementPenalty >= 3){
							$r_instatementPenalty = 100;
						} else {
							$r_instatementPenalty = 0;
						}

						$statement_data = [];
						$final_total = $r_instatementPenalty * 2;
						$memberPayment = PaymentUtil::generateMemberPayables(
							$yearpaid,
							$year_code,
							$chap_dues,
							$natl_dues,
							0
						);

						foreach($memberPayment->paymentLineItems as $paymentLineItem){
							$data = array(
								'yearcovered' => $paymentLineItem->year,
								'total_chap_dues' => $paymentLineItem->sub_total_chap_dues,
								'total_natl_dues' => $paymentLineItem->sub_total_natl_dues,
								'total_amount' => $paymentLineItem->sub_total_chap_dues + $paymentLineItem->sub_total_natl_dues
							);
							$final_total += $paymentLineItem->sub_total_chap_dues + $paymentLineItem->sub_total_natl_dues;
							$statement_data[] = $data;
						}

						return json_encode([
							'result' => 'success',
							'yearpayables' => $yearpayables,
							'statement_data' => $statement_data,
							'statement' => $members_data,
							'rstate' => $r_instatementPenalty,
							'total' => $final_total
						]);

					} else {
						return json_encode([
							'result' => 'failed',
							'message' => 'Update this Member Year of Membership.'
						]);
					}
				}

			} else {
				return json_encode([
					'result' => 'failed',
					'message' => 'SNUM is not existing. Please report this error.'
				]);
			}
		}
		return json_encode([
			'result' => 'failed',
			'message' => 'Unexpected Process Error. Please report this error.'
		]);
	} 

	public function createPayment(Request $request){

		$validation = Validator::make($request->all(), [
            'or_number' => 'required',
			'totalpay' => 'required'
        ]);

		if ($validation->fails())
        {
            return json_encode([
            	'result' => 'failed', 
            	'message' => 'Invalid Data Detected. Please try again. ',
            	'error' => $validation->errors()->all()
            ]);

		}
		
		$newPayment = Payment::create([
			'chap_code' => $request->chap_code,
			'given' => $request->given,
			'middle' => $request->middle,
			'r_statemnt' => $request->r_statemnt,
			'or_number' => $request->or_number,
			'payables' => $request->payables,
			'remarks' => $request->remarks,
			'snum' => $request->snum,
			'sur' => $request->sur,
			'totalpay' => $request->totalpay,
			'last_pay' => $request->last_pay,
			'date_paid' => $request->date_paid,
			'life' => $request->life
		])
		->id;
		$id = $newPayment;
		if($newPayment){

			$payment_details = [];
			$detailsData = $request->payment_details;
			foreach ($detailsData as $details) {
				$payment_details[] = [
					'payment_id' => $id,
					'year' => $details['yearcov'],
					'rfnatl' => $details['rfnatl'],
					'rfchap' => $details['rfchap'],
					'natl_dues' => $details['natl_dues'],
					'chap_dues' => $details['chap_dues'],
					'id_fee' => $details['id_fee']
				];
			}
			
			$newPaymentDetails = PaymentDetail::insert($payment_details);

			if($newPaymentDetails){
				return json_encode([
					'result' => 'success',
					'message' => 'Successfully Updated!'
				]);
			}
		}

		return json_encode([
			'result' => 'failed',
			'message' => 'Something error report to our developer.'
		]);
	}

	public function getPaymentHistory($snum){
		$payments = DB::table('payment')
		->selectRaw("
			or_number,
			payables,
			remarks,
			r_statemnt,
			DATE_FORMAT(STR_TO_DATE(last_pay, '%d/%m/%Y'), '%Y') AS 'last_pay',
			date_paid,
			totalpay,
			life
			")
		->where('snum', $snum)
		->paginate();
		if($payments){
			$payment_data = [];
			foreach ($payments as $value){
				$remarks;
				//LIFE
				if($value->life == 1){
					$remarks = 'LIFE MEMBER';
				} else {
					$remarks = $value->remarks;
				}
				$data = [
					'or_number' => $value->or_number,
					'payables' => $value->payables,
					'remarks' => $remarks,
					'r_statemnt' => $value->r_statemnt,
					'last_pay' => $value->last_pay,
					'totalpay' => $value->totalpay,
					'date_paid' => $value->date_paid
				];
				$payment_data[] = $data;
			}
			return json_encode([
				'result' => 'success',
				'payments' => $payment_data
			]);
		} else {
			return json_encode([
				'result' => 'failed',
			]);
		}
	}
}