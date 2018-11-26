<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    //
    protected $table = 'payment_details';

    protected $fillable = [
        'payment_id',
        'year',
        'natl_dues',
        'chap_dues',
        'amount'
      ];

    protected $primaryKey = 'id';
}
