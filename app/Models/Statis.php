<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statis extends Model
{
    protected $table = 'statis';

    protected $guarded = ['id'];

    protected $casts = [
        'tgl' => 'datetime',
    ];

    protected function setTglAttribute($value)
    {
        if ($value) {
            $this->attributes['tgl'] = date('Y-m-d H:i:s', strtotime($value));
        }
    }
}
