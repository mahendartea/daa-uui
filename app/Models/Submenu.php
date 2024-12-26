<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class Submenu extends Model
{
    protected $table = 'submenu';
    protected $primaryKey = 'id_sub';
    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_main', 'id_main');
    }
}
