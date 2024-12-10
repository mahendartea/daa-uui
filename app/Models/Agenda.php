<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';
    protected $guarded = [];

    protected $casts = [
        'jdwl_agenda' => 'datetime:Y-m-d',
        'jadwal_awal' => 'datetime:Y-m-d',
        'jadwal_akhir' => 'datetime:Y-m-d',
    ];
}
