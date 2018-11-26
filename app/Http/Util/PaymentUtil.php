<?php namespace App\Http\Util;

use App\Http\Model\PaymentLineItem;
use App\Http\Model\PaymentConfig;
use App\Http\Model\MembershipPayment;
use Illuminate\Support\Facades\Cache;
use Ds\Map;

use DB;

class PaymentUtil {

    public static function generateMemberPayablesOld($year_selector,$lastyearpaid, $chap_dues, $natl_dues, $id_fee)
    {

        $isComputeNextYearBatch = false;
        $memberPayment = new MembershipPayment();
        $memberPayment->chap_dues = $chap_dues;
        $memberPayment->natl_dues = $natl_dues;

        if (($year_selector - $lastyearpaid) >= 3)
        {
            $memberPayment->chap_reins_dues = 100;
            $memberPayment->nat_reins_dues = 100;
        }
        
        if($year_selector <= 2000)
        {
            $yeardiff = $year_selector - $lastyearpaid + 1;
            $paymentLineItem = new PaymentLineItem();
            $paymentLineItem->lastpayyearrange = $lastyearpaid. ' - ' .$year_selector;
            if($lastyearpaid == 2001){
                $paymentLineItem->lastpayyearrange = 2001;
            }
            $paymentLineItem->sub_total_chap_dues = $chap_dues * .20 * $yeardiff;
            $paymentLineItem->sub_total_natl_dues = 10 * $yeardiff;
            $memberPayment->addPaymentLineItem($paymentLineItem);
        }

        if ($lastyearpaid <= 2001)
        {
            if($year_selector >= 2001){
                $paymentLineItem = new PaymentLineItem();
                $paymentLineItem->lastpayyearrange = $lastyearpaid. ' - 2001';
                if($lastyearpaid == 2001){
                    $paymentLineItem->lastpayyearrange = 2001;
                }
                $paymentLineItem->sub_total_chap_dues = $chap_dues * .20 *(2002- $lastyearpaid);
                $paymentLineItem->sub_total_natl_dues = ($natl_dues * .20) * (2002 - $lastyearpaid);    
                $memberPayment->addPaymentLineItem($paymentLineItem);  
            }
            
        }

        if ($lastyearpaid <= 2002)
        {
            if($year_selector >= 2002){
                $paymentLineItem = new PaymentLineItem();
                $paymentLineItem->lastpayyearrange = '2002';
                $paymentLineItem->sub_total_chap_dues = $chap_dues ;
                $paymentLineItem->sub_total_natl_dues = $natl_dues ;    
                $memberPayment->addPaymentLineItem($paymentLineItem);
            }
        }

        if ($lastyearpaid <= 2003 || $lastyearpaid <= 2010 )
        {
            $paymentLineItem = new PaymentLineItem();
            if($year_selector > 2010){
                if($lastyearpaid > 2003){
                    $paymentLineItem->lastpayyearrange = $lastyearpaid. ' - 2010';
                    $paymentLineItem->sub_total_chap_dues =  $chap_dues * .50 *(2011 - $lastyearpaid);
                    $paymentLineItem->sub_total_natl_dues =  $natl_dues * (2011 - $lastyearpaid);    
                    $memberPayment->addPaymentLineItem($paymentLineItem); 
                } else {
                    $paymentLineItem->lastpayyearrange = '2003 - 2010';
                    $paymentLineItem->sub_total_chap_dues =  $chap_dues * .50 *(2011 - 2003);
                    $paymentLineItem->sub_total_natl_dues =  $natl_dues * (2011 - 2003);    
                    $memberPayment->addPaymentLineItem($paymentLineItem); 
                }
            } else {
                if($lastyearpaid > 2003){
                    $yeardiff = $year_selector + 1  - $lastyearpaid;
                    if($yeardiff > 0){
                        $paymentLineItem->lastpayyearrange = $lastyearpaid. ' - ' . $year_selector;
                        $paymentLineItem->sub_total_chap_dues =  $chap_dues * .50 * $yeardiff;
                        $paymentLineItem->sub_total_natl_dues =  $natl_dues * $yeardiff;    
                        $memberPayment->addPaymentLineItem($paymentLineItem); 
                    }  
                } else {
                    $yeardiff = $year_selector - 2002;
                    if($yeardiff > 0){
                        $paymentLineItem->lastpayyearrange = '2003 - ' . $year_selector;
                        if($year_selector == 2003){
                            $paymentLineItem->lastpayyearrange = '2003';
                        }
                        $paymentLineItem->sub_total_chap_dues =  $chap_dues * .50 * $yeardiff;
                        $paymentLineItem->sub_total_natl_dues =  $natl_dues * $yeardiff;    
                        $memberPayment->addPaymentLineItem($paymentLineItem); 
                    }   
                }     
            }
            
        }
        if ($lastyearpaid <= 2011 || $lastyearpaid <= 2017)
        {
            $paymentLineItem = new PaymentLineItem();
            if($year_selector > 2017){
                if($lastyearpaid > 2011){
                    $paymentLineItem->lastpayyearrange = $lastyearpaid. ' - 2017';
                    $paymentLineItem->sub_total_chap_dues =  $chap_dues *(2018- $lastyearpaid);
                    $paymentLineItem->sub_total_natl_dues =  250 * (2018 - $lastyearpaid);    
                    $memberPayment->addPaymentLineItem($paymentLineItem);  
                } else {
                    $paymentLineItem->lastpayyearrange = '2011 - 2017';
                    $paymentLineItem->sub_total_chap_dues =  $chap_dues *(2018- 2011);
                    $paymentLineItem->sub_total_natl_dues =  250 * (2018 - 2011);    
                    $memberPayment->addPaymentLineItem($paymentLineItem);
                }
            } else {
                if($lastyearpaid > 2011){
                    $yeardiff = $year_selector + 1 - $lastyearpaid;
                    if($yeardiff > 0){
                        $paymentLineItem->lastpayyearrange = $lastyearpaid. ' - ' . $year_selector;
                        $paymentLineItem->sub_total_chap_dues =  $chap_dues * $yeardiff;
                        $paymentLineItem->sub_total_natl_dues =  250 * $yeardiff;    
                        $memberPayment->addPaymentLineItem($paymentLineItem); 
                    }
                } else {
                    $yeardiff = $year_selector - 2010;
                    if($yeardiff > 0){
                        $paymentLineItem->lastpayyearrange = '2011 - ' . $year_selector;
                        if($year_selector == 2011){
                            $paymentLineItem->lastpayyearrange = '2011';
                        }
                        $paymentLineItem->sub_total_chap_dues =  $chap_dues * $yeardiff;
                        $paymentLineItem->sub_total_natl_dues =  250 * $yeardiff;    
                        $memberPayment->addPaymentLineItem($paymentLineItem); 
                    }
                }
            }
        }

        if($lastyearpaid <= 2018)
        {
           if($year_selector >= 2018){
                $paymentLineItem = new PaymentLineItem();
                $paymentLineItem->lastpayyearrange = '2018 Present';
                $paymentLineItem->sub_total_chap_dues =  500;
                $paymentLineItem->sub_total_natl_dues =  500;    
                $memberPayment->addPaymentLineItem($paymentLineItem); 
            } 
        }

       return $memberPayment;
    }

    public static function generateNewMemberPayables($year, $chap_dues, $natl_dues, $id_fee)
    {
        $memberPayment = new MembershipPayment();

        $entChapterMap = PaymentUtil::getPaymentConfig('ENT_CHAPTER');
        $entNationalMap = PaymentUtil::getPaymentConfig('ENT_NATIONAL');
        $chapterMap = PaymentUtil::getPaymentConfig('CHAPTER');
        $nationalMap = PaymentUtil::getPaymentConfig('NATIONAL');
        $idFeeMap = PaymentUtil::getPaymentConfig('ID_FEE');

        $paymentLineItem = new PaymentLineItem();           
        $paymentLineItem->year = $year;

        if (array_key_exists($year,$nationalMap)) {
            PaymentUtil::computePayment($natl_dues, $nationalMap[$year], $paymentLineItem);
        } else {
            $paymentLineItem->sub_total_natl_dues = $natl_dues;
        }

        if (array_key_exists($year,$chapterMap)) {
            PaymentUtil::computePayment($chap_dues, $chapterMap[$year], $paymentLineItem);
        } else {
            $paymentLineItem->sub_total_chap_dues = $chap_dues;
        }           

        $memberPayment->addPaymentLineItem($paymentLineItem);

        if (array_key_exists($year,$entNationalMap)) {
            $memberPayment->nat_ent_dues  =  $entNationalMap[$year]->orig_amount;
        } else {
            $memberPayment->nat_ent_dues  = $natl_dues;
        }

        if (array_key_exists($year,$entChapterMap)) {
            $memberPayment->chap_ent_dues  = $entChapterMap[$year]->orig_amount;
        } else {
            $memberPayment->chap_ent_dues  = $chap_dues;
        }  
        
        if (array_key_exists($year,$idFeeMap)) {
            $memberPayment->id_fee  = $idFeeMap[$year]->orig_amount;
        } else {
            $memberPayment->id_fee  = $id_fee;
        }  
        
        return $memberPayment;
      
    }


    public static function generateMemberPayables($year_selector,$lastyearpaid, $chap_dues, $natl_dues, $id_fee)
    {
        $memberPayment = new MembershipPayment();
        $memberPayment->chap_dues = $chap_dues;
        $memberPayment->natl_dues = $natl_dues;

        if (($year_selector - $lastyearpaid) >= 3)
        {
            $memberPayment->chap_reins_dues = 100;
            $memberPayment->nat_reins_dues = 100;
        }

        $lastyearpaid = $lastyearpaid<=1995?1996:$lastyearpaid;


        $chapterMap = PaymentUtil::getPaymentConfig('CHAPTER');
        $nationalMap = PaymentUtil::getPaymentConfig('NATIONAL');

        for ($y = $lastyearpaid ; $y<=$year_selector; $y++) {
            $paymentLineItem = new PaymentLineItem();           
            $paymentLineItem->year = $y;

            if (array_key_exists($y,$nationalMap)) {
                PaymentUtil::computePayment($natl_dues, $nationalMap[$y], $paymentLineItem);
            } else {
                $paymentLineItem->sub_total_natl_dues = $natl_dues;
            }

            if (array_key_exists($y,$chapterMap)) {
                PaymentUtil::computePayment($chap_dues, $chapterMap[$y], $paymentLineItem);
            } else {
                $paymentLineItem->sub_total_chap_dues = $chap_dues;
            }           
            $memberPayment->addPaymentLineItem($paymentLineItem);
        }
       return $memberPayment;
    }

    private static function computePayment($orig_amount, $paymentConfig, $paymentLineItem)
    {
        $amount = $orig_amount;
        $discount = 0;

        if ($paymentConfig->discount_type == 'FIX') {
            $amount = $paymentConfig->orig_amount;
            $discount = $paymentConfig->discount_amount;
        }

        if ($paymentConfig->discount_type == 'PERCENT') {
            $amount = $orig_amount;
            $discount = $orig_amount * ($paymentConfig->discount_amount/100);
        }


        if ($paymentConfig->payment_type=='CHAPTER') {
            $paymentLineItem->sub_total_chap_dues =  $amount;
            $paymentLineItem->sub_total_chap_discount = $discount; 
        }

        if ($paymentConfig->payment_type == 'NATIONAL') {
            $paymentLineItem->sub_total_natl_dues = $amount;    
            $paymentLineItem->sub_total_natl_discount = $discount; 
        }

    }

    public static function getPaymentConfig($configName)
    {
        if (!Cache::has('CHAPTER') || !Cache::has('NATIONAL')) {
            $paymentConfigs = PaymentConfig::select('start_year', 'end_year', 'orig_amount', 'discount_amount',
                                   'payment_type', 'discount_type', 'config_name')
                                   ->where('enable','1')
                                   ->orderBy('payment_type')->get();

            $chapterMap = array();
            $nationalMap = array();
            $entChapterMap = array();
            $entNationalMap = array();
            $idFeeMap = array();

            foreach ($paymentConfigs as $paymentConfig) {
                if ($paymentConfig->payment_type == 'CHAPTER')
                {
                    PaymentUtil::createYearDetails($chapterMap,$paymentConfig);
                } else if ($paymentConfig->payment_type == 'NATIONAL') {
                    PaymentUtil::createYearDetails($nationalMap,$paymentConfig);
                } else if ($paymentConfig->payment_type == 'ENT_NATIONAL') {
                    PaymentUtil::createYearDetails($entNationalMap,$paymentConfig);
                } else if ($paymentConfig->payment_type == 'ENT_CHAPTER') {
                    PaymentUtil::createYearDetails($entChapterMap,$paymentConfig);
                } else if ($paymentConfig->payment_type == 'ID_FEE') {
                    PaymentUtil::createYearDetails($idFeeMap,$paymentConfig);
                }
            } 

            Cache::forever('CHAPTER', $chapterMap);
            Cache::forever('NATIONAL', $nationalMap);
            Cache::forever('ENT_NATIONAL', $entNationalMap);
            Cache::forever('ENT_CHAPTER', $entChapterMap);
            Cache::forever('ID_FEE', $idFeeMap);
        }
        return  Cache::get($configName);
    }

    public static function loadPaymentConfig()
    {
       Cache::forget('CHAPTER');
       Cache::forget('NATIONAL');
       PaymentUtil::getPaymentConfig('CHAPTER');
    }

    private static function createYearDetails(&$map, $paymentConfig)
    {
        for ($y = $paymentConfig->start_year; $y<=$paymentConfig->end_year; $y++) {
            $map[$y] = $paymentConfig;
        } 
    }



}

