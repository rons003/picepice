<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $table = 'membership';

    protected $fillable = [
        'address',
        'address1',
        'address2',
        'address3',
        'appl_code',
        'asn',
        'associate',
        'birthdate',
        'birthplace',
        'cell_no',
        'chap_code',
        'chap_no',
        'chap_pres',
        'civilstat',
        'date_life',
        'date_mem',
        'date_reg',
        'deceased',
        'degree',
        'duplicate',
        'e_mail',
        'ec_stat',
        'ec_year',
        'fax',
        'fellow',
        'gender',
        'given',
        'home_fax',
        'home_tel',
        'id_fee',
        'ifadd_ok',
        'inactive',
        'life_chap',
        'life_no',
        'mem_code',
        'mem_code_n',
        'middle',
        'middlename',
        'oathtaker',
        'office',
        'old_chap',
        'position',
        'praktis',
        'prc_no',
        'prefdaddr',
        'school',
        'sektor',
        'snum',
        'sur',
        'tel_fax',
        'type_mem',
        'year',
        'yeargrad',
        'yr_code',
        'yrsinactiv',
        'xero_id',
        'user_id',
        'is_life_member',
        'mem_not_paid'
    ];

    protected $primaryKey = 'id';
}
