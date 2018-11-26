<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Bluecard extends Model
{
    //
    protected $table = 'blue_card';

    protected $fillable = [
        'address',
        'address1'
    ];

    protected $primaryKey = 'id';
}
