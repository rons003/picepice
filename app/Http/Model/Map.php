<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    //
    protected $table = 'map';

    protected $fillable = [
        'name',
        'snum',
        'mailing',
        'mailing2',
        'payment',
        'totalpay'
    ];

    protected $primaryKey = 'id';
}
