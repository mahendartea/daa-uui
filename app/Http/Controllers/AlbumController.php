<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Inertia\Inertia;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::orderByDesc('created_at')->orderByDesc('updated_at')->get();
        return Inertia::render('Album/Index', compact('albums'));
    }

    public function create()
    {
        return Inertia::render('Album/Create');
    }

    public function store()
    {
        $data = request()->validate([
            'nama_album' => 'required',
        ]);

        Album::create($data);

        return redirect()->route('albums.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Album berhasil disimpan',
            'life' => 3000
        ]);
    }

    public function edit(Album $album)
    {
        return Inertia::render('Album/Edit', [
            'album' => $album
        ]);
    }

    public function update(Album $album)
    {
        $data = request()->validate([
            'nama_album' => 'required',
        ]);

        $album->update($data);

        return redirect()->route('albums.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Album berhasil diperbarui',
            'life' => 3000
        ]);
    }

    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->route('albums.index');
    }
}
