<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MidtemCalender extends Model
{
    protected $table = 'ak_jdwl_mid';
    protected $primaryKey = 'id_jmid';

    protected $fillable = [
        'id_thn',
        'semester',
        'nama',
        'file',
        'tgl_upload'
    ];

    protected $casts = [
        'tgl_upload' => 'datetime',
        'id_thn' => 'integer'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'tgl_upload'
    ];
}
