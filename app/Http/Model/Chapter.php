<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //
    protected $table = 'chapter';

    protected $fillable = [
        'chap_code',
        'chapter',
        'chap_dues',
        'natl_dues',
        'establishe',
        'reptype',
        'region'
    ];

    protected $primaryKey = 'id';
}
