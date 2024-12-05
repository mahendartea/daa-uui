<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'upload';

    public $timestamps = false;

    protected $fillable = [
        'nama_file',
        'link_external',
        'path',
        'tgl_upload',
        'created',
    ];

    protected $casts = [
        'tgl_upload' => 'datetime',
    ];
}
