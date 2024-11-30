<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Inertia\Inertia;
use App\Models\Galery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GaleryController extends Controller
{
    public function index(Request $request)
    {
        $galeries = Galery::with('album')->get();

        if ($request->session()->has('message')) {
            $message = $request->session()->get('message');
        } else {
            $message = '';
        }

        return Inertia::render('Galery/Index', compact('galeries', 'message'));
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

    public function edit(Galery $galery)
    {
        $albums = Album::all();
        return Inertia::render('Galery/Edit', [
            'galery' => $galery,
            'albums' => $albums
        ]);
    }

    public function update(Request $request, Galery $galery)
    {
        $rules = [];
        $messages = [];

        // Only validate fields that are present in the request
        if ($request->hasFile('gambar')) {
            $rules['gambar'] = 'image|max:5000';
            $messages['gambar.image'] = 'File harus berupa gambar';
            $messages['gambar.max'] = 'Ukuran gambar maksimal 5MB';
        }

        if ($request->has('album_id')) {
            $rules['album_id'] = 'required';
            $messages['album_id.required'] = 'Album harus dipilih';
        }

        if ($request->has('ket_gambar')) {
            $rules['ket_gambar'] = 'required|string';
            $messages['ket_gambar.required'] = 'Keterangan gambar harus diisi';
            $messages['ket_gambar.string'] = 'Keterangan gambar harus berupa teks';
        }

        if ($request->has('tgl_upload')) {
            $rules['tgl_upload'] = 'required|date';
            $messages['tgl_upload.required'] = 'Tanggal upload harus diisi';
            $messages['tgl_upload.date'] = 'Format tanggal tidak valid';
        }

        if ($request->has('slide_home')) {
            $rules['slide_home'] = 'boolean';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [];

        if ($request->has('album_id')) {
            $data['album_id'] = is_array($request->album_id) ? $request->album_id['value'] : $request->album_id;
        }

        if ($request->has('ket_gambar')) {
            $data['ket_gambar'] = $request->ket_gambar;
        }

        if ($request->has('slide_home')) {
            $data['slide_home'] = (bool) $request->slide_home;
        }

        if ($request->has('tgl_upload')) {
            $data['tgl_upload'] = date('Y-m-d', strtotime($request->tgl_upload));
        }

        if ($request->hasFile('gambar')) {
            // Delete old image
            if (file_exists(public_path($galery->gambar))) {
                unlink(public_path($galery->gambar));
            }

            // Upload new image
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/gallery'), $imageName);
            $data['gambar'] = 'images/gallery/' . $imageName;
        }

        $galery->update($data);

        return redirect()->route('galeries.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Galeri berhasil diperbarui',
            'life' => 3000
        ]);
    }
}
