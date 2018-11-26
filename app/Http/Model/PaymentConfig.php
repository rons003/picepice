<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentConfig extends Model
{
    //
    protected $table = 'payment_config';

    protected $fillable = [
        'start_year',
        'end_year',
        'orig_amount',
        'discount_amount',
        'payment_type',
        'discount_type',
        'config_name'
      ];

    protected $primaryKey = 'id';
}
