<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'payment';

    protected $fillable = [
        'chap_code',
        'chap_dues',
        'natl_dues',
        'ent_chap',
        'ent_natl',
        'entrance',
        'life_chap',
        'life_natl',
        'given',
        'last_pay',
        'date_paid',
        'middle',
        'or_number',
        'payables',
        'r_statemnt',
        'remarks',
        'snum',
        'sur',
        'totalpay',
        'status',
        'paypal_id',
        'life'
    ];

    protected $primaryKey = 'id';
}
