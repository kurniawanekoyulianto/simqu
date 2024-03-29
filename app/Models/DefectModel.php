<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefectModel extends Model
{
    protected $table = 'tb_master_defect'; //disesuaikan dengan database
    protected $primaryKey = 'id_defect'; //disesuaikan dengan database

    protected $fillable = [
    	'defect',
        'kode_defect',
        'id_departemen',
        'id_sub_departemen',
        'created_at',
        'updated_at'
    ];
}
