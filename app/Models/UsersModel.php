<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'tb_master_users'; //disesuaikan dengan database
    protected $primaryKey = 'id_user'; //disesuaikan dengan database

    protected $fillable = [
    	'kode_user',
    	'nama_user',
        'jenis_user',
    	'password',
    	'token',
        'id_departemen',
        'id_sub_departemen',
        'picture',
        'email',
        'created_at',
        'creator',
        'updated_at',
        'pic'
    ];
}
