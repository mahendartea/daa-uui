<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Galery;
use Illuminate\Http\Request;

class GaleryController extends Controller
{
    public function index()
    {
        $galeries = Galery::with('album')->get();
        return Inertia::render('Galery/Index', compact('galeries'));
    }

    public function destroy(Galery $galery)
    {
        $galery->delete();
        return redirect()->route('galeries.index');
    }

    public function create()
    {
        return Inertia::render('Galery/Create');
    }
}
