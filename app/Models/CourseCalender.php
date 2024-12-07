<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCalender extends Model
{
    protected $table = 'ak_jdwl_kuliah';

    protected $primaryKey = 'id_jkul';

    protected $fillable = [
        'id_thn',
        'semester',
        'nama',
        'file',
        'tgl_upload'
    ];

    protected $casts = [
        'tgl_upload' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
