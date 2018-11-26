<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $table = 'student';

    protected $fillable = [
        'sur',
        'given',
        'middle',
        'e_mail',
        'stud_num'
    ];

    protected $primaryKey = 'id';
}
