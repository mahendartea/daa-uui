<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    protected $table = 'galery';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['tgl_upload'] = date('Y-m-d H:i:s', strtotime($value));
    }
}
