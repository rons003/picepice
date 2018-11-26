<?php

namespace App\Http\Model;

class MembershipPayment extends MagicClass {

    protected $total_chap_dues = 0;
    protected $total_natl_dues = 0;
    protected $net_chap_dues = 0;
    protected $net_natl_dues = 0;
    protected $total_chap_discount = 0;
    protected $total_natl_discount = 0;
    protected $chap_reins_dues = 0;
    protected $nat_reins_dues = 0;
    protected $chap_ent_dues = 0;
    protected $nat_ent_dues = 0;
    protected $chap_dues = 0;
    protected $natl_dues= 0;
    protected $id_fee= 0;
    protected $paymentLineItems = [];
    
    public function addPaymentLineItem(PaymentLineItem $paymentLineItem) {

        $paymentLineItem->net_total_chap_dues = $paymentLineItem->sub_total_chap_dues - $paymentLineItem->sub_total_chap_discount;
        $paymentLineItem->net_total_natl_dues = $paymentLineItem->sub_total_natl_dues - $paymentLineItem->sub_total_natl_discount;
        $this->total_chap_dues += $paymentLineItem->sub_total_chap_dues;
        $this->total_natl_dues += $paymentLineItem->sub_total_natl_dues;
        $this->total_chap_discount += $paymentLineItem->sub_total_chap_discount;
        $this->total_natl_discount += $paymentLineItem->sub_total_natl_discount;
        $this->net_chap_dues += $paymentLineItem->net_total_chap_dues ;
        $this->net_natl_dues += $paymentLineItem->net_total_natl_dues;

        array_push($this->paymentLineItems,$paymentLineItem);        
    }

    public function getTotalDues()
    {
        return ($this->chap_reins_dues + $this->nat_reins_dues + $this->chap_ent_dues 
                + $this->id_fee
                + $this->nat_ent_dues + $this->net_chap_dues + $this->net_natl_dues);
    }


}

