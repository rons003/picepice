<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Life extends Model
{
    //
    protected $table = 'life';

    protected $fillable = [
        'add1',
        'add2',
        'add3',
        'amount',
        'birthdate',
        'chap_share'
    ];

    protected $primaryKey = 'id';
}
