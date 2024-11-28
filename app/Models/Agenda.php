<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';
    protected $guarded = [];

    protected $casts = [
        'jdwl_agenda' => 'datetime',
        'jadwal_awal' => 'datetime',
        'jadwal_akhir' => 'datetime',
    ];
}
