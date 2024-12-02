<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upload;
use App\Models\Document;

class Kalender extends Model
{
    use HasFactory;

    protected $table = 'ak_klnder';

    protected $fillable = [
        'thnajr',
        'nama',
        'upload_id',
        'tgl_upload'
    ];

    protected $casts = [
        'tgl_upload' => 'datetime',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'upload_id');
    }
}
