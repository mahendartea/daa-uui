<?php

namespace App\Http\Controllers;

use App\Models\Headline;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class HeadlineController extends Controller
{
    public function index(Request $request)
    {
        $headline = Headline::first();

        return Inertia::render('Headline/Index', [
            'headline' => $headline,
            'message' => session('message'),
        ]);
    }

    public function create()
    {
        // Check if headline already exists
        if (Headline::exists()) {
            return redirect()->route('headline.index')->with('message', [
                'severity' => 'warn',
                'summary' => 'Perhatian',
                'detail' => 'Headline sudah ada, silahkan edit headline yang ada',
                'life' => 3000
            ]);
        }

        return Inertia::render('Headline/Create');
    }

    public function store(Request $request)
    {
        // Check if headline already exists
        if (Headline::exists()) {
            return back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Headline sudah ada',
                'life' => 3000
            ]);
        }

        $validated = $request->validate([
            'isi_headline' => 'required|string',
            'gambar_headline' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ], [
            'isi_headline.required' => 'Isi headline harus diisi',
            'gambar_headline.required' => 'Gambar harus diupload',
            'gambar_headline.image' => 'File harus berupa gambar',
            'gambar_headline.mimes' => 'Gambar harus berformat jpeg, png, atau jpg',
            'gambar_headline.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        try {
            $image = $request->file('gambar_headline');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/headline'), $imageName);

            Headline::create([
                'isi_headline' => $validated['isi_headline'],
                'gambar_headline' => $imageName,
            ]);

            return redirect()->route('headline.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Sukses',
                'detail' => 'Headline berhasil ditambahkan',
                'life' => 3000
            ]);

        } catch (\Exception $e) {
            if (isset($imageName) && file_exists(public_path('uploads/headline/' . $imageName))) {
                unlink(public_path('uploads/headline/' . $imageName));
            }

            return back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Terjadi kesalahan saat menyimpan data',
                'life' => 3000
            ]);
        }
    }

    public function edit($id)
    {
        $headline = Headline::findOrFail($id);
        return Inertia::render('Headline/Edit', [
            'headline' => $headline
        ]);
    }

    public function update(Request $request, $id)
    {
        $headline = Headline::findOrFail($id);

        $rules = [
            'isi_headline' => 'required|string',
        ];

        if ($request->hasFile('gambar_headline')) {
            $rules['gambar_headline'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        $validated = $request->validate($rules, [
            'isi_headline.required' => 'Isi headline harus diisi',
            'gambar_headline.required' => 'Gambar harus diupload',
            'gambar_headline.image' => 'File harus berupa gambar',
            'gambar_headline.mimes' => 'Gambar harus berformat jpeg, png, atau jpg',
            'gambar_headline.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        try {
            $updateData = [
                'isi_headline' => $validated['isi_headline'],
            ];

            if ($request->hasFile('gambar_headline')) {
                $image = $request->file('gambar_headline');
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Delete old image if exists
                $oldImagePath = public_path('uploads/headline/' . $headline->gambar_headline);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // Upload new image
                $image->move(public_path('uploads/headline'), $imageName);
                $updateData['gambar_headline'] = $imageName;
            }

            $headline->update($updateData);

            return redirect()->route('headline.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Sukses',
                'detail' => 'Headline berhasil diperbarui',
                'life' => 3000
            ]);

        } catch (\Exception $e) {
            if (isset($imageName) && file_exists(public_path('uploads/headline/' . $imageName))) {
                unlink(public_path('uploads/headline/' . $imageName));
            }

            return back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Terjadi kesalahan saat memperbarui data',
                'life' => 3000
            ]);
        }
    }
}
