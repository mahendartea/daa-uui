<?php

namespace App\Http\Controllers;

use App\Models\Album;
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
        $albums = Album::all();
        return Inertia::render('Galery/Create', compact('albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar.*' => 'required|image|max:5000',
            'album_id' => 'required',
            'ket_gambar' => 'required|string',
            'slide_home' => 'boolean',
            'tgl_upload' => 'required|date'
        ]);

        $albumId = is_array($request->album_id) ? $request->album_id['value'] : $request->album_id;
        $uploadedImages = [];

        foreach ($request->file('gambar') as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/gallery'), $imageName);

            Galery::create([
                'gambar' => 'images/gallery/' . $imageName,
                'album_id' => $albumId,
                'ket_gambar' => $request->ket_gambar,
                'slide_home' => (bool) $request->slide_home,
                'tgl_upload' => $request->tgl_upload
            ]);

            $uploadedImages[] = $imageName;
        }

        return redirect()->route('galeries.index');
    }
}
