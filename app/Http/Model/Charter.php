<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Charter extends Model
{
    //
    protected $table = 'charter';

    protected $fillable = [
        'sur',
        'given',
        'middle',
        'e_mail',
        'stud_num'
    ];

    protected $primaryKey = 'id';
}
