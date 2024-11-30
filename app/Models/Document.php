<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'upload';

    protected $fillable = [
        'nama_file',
        'path',
        'tgl_upload',
        'created',
    ];

    protected $dates = [
        'tgl_upload',
    ];

    public $timestamps = false;
}
