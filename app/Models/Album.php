<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'album_gambar';
    protected $guarded = [];
    protected $primaryKey = 'id_album';


    public function galeries()
    {
        return $this->hasMany(Galery::class, 'album_id');
    }
}
