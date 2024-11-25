<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Galery;
use Illuminate\Http\Request;

class GaleryController extends Controller
{
    public function index()
    {
        $galeries = Galery::all();
        return Inertia::render('Galery/Index', compact('galeries'));
    }

    public function destroy(Galery $galery)
    {
        $galery->delete();
        return redirect()->route('galeries.index');
    }
}
