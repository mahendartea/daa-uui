<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Headline extends Model
{
    protected $table = 'headline';
    protected $primaryKey = 'id_headline';

    protected $fillable = [
        'isi_headline',
        'gambar_headline',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}
