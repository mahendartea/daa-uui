<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'mainmenu';
    protected $primaryKey = 'id_main';
    protected $guarded = [];

    public function submenu()
    {
        return $this->hasMany(Submenu::class, 'id_main', 'id_main')
                    ->where('aktif', 'Y')
                    ->orderBy('urutan');
    }
}
