<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $table = 'invoice';

    protected $fillable = [
        'contactid',
        'invoiceid',
        'invoicenumber',
        'amountdue',
        'subtotal'
    ];

    protected $primaryKey = 'id';
}
