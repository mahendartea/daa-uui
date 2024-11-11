<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $table = 'post';

    const CREATED_AT = 'tgl';
    const UPDATED_AT = 'updated';
}
