<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Invoice;
use App\Http\Model\Member;
use App\Http\Model\PaymentDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use App\Http\Util\PaymentUtil;
use Illuminate\Support\Facades\Log;
use Redirect;
use Session;
use URL;

use Config;

class MemberPaymentController extends Controller
{
    
    private $_api_context;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('member');

        /** PayPal api context **/
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }   

    public function index()
    {
        return view('paywithpaypal');
    }

    public function viewDuesDB(Request $request)
    {
        $mem_info = Member::leftJoin('chapter', 'membership.chap_code', '=', 'chapter.chap_code')
        ->select('snum','membership.last_pay','sur','given','middle','chapter.chap_code','chapter.chap_dues','chapter.natl_dues')
        ->where('prc_no', Auth::user()->prc_no)
        ->first();

        $payment = \App\Http\Model\Payment::select('id','chap_code','chap_dues','natl_dues','ent_chap','ent_natl','entrance','life_chap',
        'life_natl','given','last_pay','date_paid','middle','or_number','payables','r_statemnt','remarks','snum','sur','totalpay','status')
        ->where('snum', session('snum'))
        ->where('status', 7)
        ->first();

        if (!$payment)
        {

            $currentYear = date('Y');
            $last_pay = $mem_info->last_pay<=1996?1996:$mem_info->last_pay;
            $member_payment = PaymentUtil::generateMemberPayables($currentYear,$last_pay,$mem_info->chap_dues,$mem_info->natl_dues,150);

            $transactionSuccessful = false;

            DB::transaction(function() use($request,$mem_info, $member_payment, $currentYear, &$transactionSuccessful)
            {
            
                $newPayment =  \App\Http\Model\Payment::create([
                    'chap_code' => $mem_info->chap_code,
                    'given' => $mem_info->given,
                    'middle' => $mem_info->middle,
                    'r_statemnt' => $member_payment->total_chap_dues + $member_payment->total_natl_dues,
                    'natl_dues' => $member_payment->total_natl_dues,
                    'chap_dues' => $member_payment->total_chap_dues,
                    'ent_natl' => $member_payment->nat_reins_dues,
                    'ent_chap' => $member_payment->chap_reins_dues,
                    'payables' => $currentYear,
                    'remarks' => "Paypal Payment",
                    'snum' => $mem_info->snum,
                    'sur' => $mem_info->sur,
                    'status' => 7, //membership type
                    'totalpay' => $member_payment->total_chap_dues + $member_payment->total_natl_dues + $member_payment->nat_reins_dues + $member_payment->nat_reins_dues
                    ])
                    ->id;
                    
                $id = $newPayment;

                if($newPayment){
                $payment_details = [];
                $detailsData = $request->payment_details;
                foreach ($member_payment->paymentLineItems as $o)  {
                    $payment_details[] = [
                        'payment_id' => $id,
                        'year' => $o->lastpayyearrange,
                        'rfnatl' => 0,
                        'rfchap' => 0,
                        'natl_dues' => $o->sub_total_natl_dues,
                        'chap_dues' => $o->sub_total_chap_dues,
                        'id_fee' => 0
                    ];
                }			
                $newPaymentDetails = PaymentDetail::insert($payment_details);			
                }
            
                $transactionSuccessful = true;

            });               
            

            $payment = \App\Http\Model\Payment::select('id','chap_code','chap_dues','natl_dues','ent_chap','ent_natl','entrance','life_chap',
            'life_natl','given','last_pay','date_paid','middle','or_number','payables','r_statemnt','remarks','snum','sur','totalpay','status')
            ->where('snum', session('snum'))
            ->where('status', 7)
            ->first();

        }
        $paymentLineItems = PaymentDetail::select('year','natl_dues','chap_dues')->where('payment_id', $payment['id'])->get();
        return view('members_page/create_payment',compact('payment','mem_info','paymentLineItems'));


    }

    public function viewDues(Request $request)
    {
     
        $mem_info = Member::leftJoin('chapter', 'membership.chap_code', '=', 'chapter.chap_code')
        ->select('remarks', 'is_life_member', 'snum',DB::raw("DATE_FORMAT(STR_TO_DATE(membership.last_pay, '%a %b %j %T %Y'), '%Y') last_pay "),'sur','given',
                'middle','chapter.chap_code','chapter.chap_dues','chapter.natl_dues','mem_not_paid','membership.year')
        ->where('prc_no', Auth::user()->prc_no)
        ->first();

        if ($mem_info->is_life_member)
        {

            return redirect('/member/lifemember');
        }

        if ($mem_info->year && $mem_info->mem_not_paid > 0)
        {
            $member_payment = PaymentUtil::generateNewMemberPayables($mem_info->year,$mem_info->chap_dues,$mem_info->natl_dues,150);
            $paymentLineItems = $member_payment->paymentLineItems; 
            $mem_info['is_new'] = true;
            return view('members_page.duepayment',compact('member_payment','payment','mem_info','paymentLineItems'));

        } else {

            /*
            $payment = \App\Http\Model\Payment::select('id','chap_code','chap_dues','natl_dues','ent_chap','ent_natl','entrance','life_chap',
            'life_natl','given','last_pay','date_paid','middle','or_number','payables','r_statemnt','remarks','snum','sur','totalpay','status')
            ->where('snum', session('snum'))
            ->where('status', 7)
            ->first();
            */

            $member_payment = null;

            //if (!$payment)
            //{
            $currentYear = date('Y');
            $member_payment = PaymentUtil::generateMemberPayables($currentYear,$mem_info->last_pay,$mem_info->chap_dues,$mem_info->natl_dues,150);
            //}

            $paymentLineItems = $member_payment->paymentLineItems; 

            return view('members_page.duepayment',compact('member_payment','payment','mem_info','paymentLineItems'));
        }
    }

    public function updatePaypal(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = $request->paymentID;        
        $res = \App\Http\Model\Payment::where('paypal_id',$request->paymentID)->update(['status'=>1]);
        Member::where('prc_no',Auth::user()->prc_no)->update(['last_pay'=>2018]);
    }

    public function paymentPaypal(Request $request)
    {
        $member_payment = null;      
        
        $mem_info = Member::leftJoin('chapter', 'membership.chap_code', '=', 'chapter.chap_code')
        ->select('snum',DB::raw("DATE_FORMAT(STR_TO_DATE(membership.last_pay, '%a %b %j %T %Y'), '%Y') last_pay "),'sur','given',
                'middle','chapter.chap_code','chapter.chap_dues','chapter.natl_dues','mem_not_paid','membership.year')
        ->where('prc_no', Auth::user()->prc_no)
        ->first();


        if ($mem_info->year && $mem_info->mem_not_paid ==0)
        {
            $member_payment = PaymentUtil::generateNewMemberPayables($mem_info->year,$mem_info->chap_dues,$mem_info->natl_dues,150);
            $paymentLineItems = $member_payment->paymentLineItems; 
            $mem_info['is_new'] = true;

        } else {
            /*
            $payment = \App\Http\Model\Payment::select('id','chap_code','chap_dues','natl_dues','ent_chap','ent_natl','entrance','life_chap',
            'life_natl','given','last_pay','date_paid','middle','or_number','payables','r_statemnt','remarks','snum','sur','totalpay','status')
            ->where('snum', session('snum'))
            ->where('status', 7)
            ->first();
            */
            $member_payment = null;

            //if (!$payment)
            //{
            $currentYear = date('Y');
            $member_payment = PaymentUtil::generateMemberPayables($currentYear,$mem_info->last_pay,$mem_info->chap_dues,$mem_info->natl_dues,150);
            //}

            $paymentLineItems = $member_payment->paymentLineItems; 
        }

        $payment = null;


        if ($member_payment)
        {

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $payerInfo = new PayerInfo();
            $payer->setPayerInfo($payerInfo);
            //$member_payment = PaymentUtil::generateMemberPayables(2018,$last_pay,150,200,150);
            $item_list = new ItemList();
            $total_amount = 0;

            /*
            foreach ($member_payment->paymentLineItems as $o) {
                
                $sub_payment = $o->sub_total_natl_dues+$o->sub_total_chap_dues;
                $total_amount += $sub_payment;                
                $item->setName($o->lastpayyearrange)
                    ->setCurrency('PHP')
                    ->setQuantity(1)
                    ->setPrice($sub_payment); 
                $item_list->addItem($item);
            }*/

            $item = new Item();
            $item->setName('National Dues')
                    ->setCurrency('PHP')
                    ->setQuantity(1)
                    ->setPrice($member_payment->net_natl_dues); 
            $item_list->addItem($item);   

            $item = new Item();
            $item->setName('Chapter Dues')
                    ->setCurrency('PHP')
                    ->setQuantity(1)
                    ->setPrice($member_payment->net_chap_dues); 
            $item_list->addItem($item);              
             
            if ($member_payment->chap_reins_dues > 0) {
              $item = new Item();
              $item->setName('Reinstatement Fee')
                    ->setCurrency('PHP')
                    ->setQuantity(1)
                    ->setPrice($member_payment->nat_reins_dues+$member_payment->chap_reins_dues); 
              $item_list->addItem($item);              
            }

            if ($member_payment->chap_ent_dues > 0) {
              $item = new Item();
              $item->setName('Entrance Fee')
                    ->setCurrency('PHP')
                    ->setQuantity(1)
                    ->setPrice($member_payment->chap_ent_dues+$member_payment->nat_ent_dues); 
              $item_list->addItem($item);               
            }

            if ($member_payment->id_fee > 0) {
              $item = new Item();
              $item->setName('ID Fee')
                    ->setCurrency('PHP')
                    ->setQuantity(1)
                    ->setPrice($member_payment->id_fee); 
              $item_list->addItem($item);
            }
            
            $amount = new Amount();
            $amount->setCurrency('PHP')
                ->setTotal($member_payment->getTotalDues());
            
            $transaction = new Transaction();
            $transaction->setAmount($amount )
                ->setItemList($item_list)
                ->setDescription('Membership Payment');
            
            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::to('member/payment/update')) /** Specify return URL **/
                ->setCancelUrl(URL::to('member/payment/update'));
                
            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
            /** dd($payment->create($this->_api_context));exit; **/
            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                Log::error($ex->getCode()); // Prints the Error Code
                Log::error($ex->getData()); // Prints the detailed error message 
                /*
                if (\Config::get('app.debug')) {
                    \Session::put('error', 'Connection timeout');
                    return Redirect::to('/');
                } else {
                    \Session::put('error', 'Error occurs, Please contact our Admin');
                    return Redirect::to('/');
                }*/
            }      
        }
        return $payment;
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return Redirect::to('/');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
       
        return Redirect::to('/');
    }



}
