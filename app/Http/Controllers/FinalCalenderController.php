<?php

namespace App\Http\Controllers;

use App\Models\FinalCalender;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class FinalCalenderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $finals = FinalCalender::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('id_thn', 'like', "%{$search}%")
                      ->orWhere('semester', 'like', "%{$search}%");
                });
            })
            ->orderBy('tgl_upload', 'desc')
            ->paginate($perPage);

        return Inertia::render('FinalCalender/Index', [
            'finals' => $finals,
            'message' => session('message'),
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('FinalCalender/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_thn' => 'required|integer',
            'semester' => 'required|string|max:20',
            'nama' => 'required|string|max:200',
            'file' => 'required|file|mimes:pdf|max:2048', // Max 2MB
        ], [
            'id_thn.required' => 'Tahun harus diisi',
            'id_thn.integer' => 'Tahun harus berupa angka',
            'semester.required' => 'Semester harus diisi',
            'semester.max' => 'Semester maksimal 20 karakter',
            'nama.required' => 'Nama harus diisi',
            'nama.max' => 'Nama maksimal 200 karakter',
            'file.required' => 'File harus diupload',
            'file.file' => 'File tidak valid',
            'file.mimes' => 'File harus berformat PDF',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/final'), $fileName);

            FinalCalender::create([
                'id_thn' => $validated['id_thn'],
                'semester' => $validated['semester'],
                'nama' => $validated['nama'],
                'file' => $fileName,
                'tgl_upload' => now()
            ]);

            return redirect()->route('final-calender.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Sukses',
                'detail' => 'Jadwal final berhasil ditambahkan',
                'life' => 3000
            ]);

        } catch (\Exception $e) {
            if (isset($fileName) && file_exists(public_path('uploads/final/' . $fileName))) {
                unlink(public_path('uploads/final/' . $fileName));
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
        $final = FinalCalender::findOrFail($id);
        return Inertia::render('FinalCalender/Edit', [
            'final' => $final
        ]);
    }

    public function update(Request $request, $id)
    {
        $final = FinalCalender::findOrFail($id);

        $rules = [
            'id_thn' => 'required|integer',
            'semester' => 'required|string|max:20',
            'nama' => 'required|string|max:200',
        ];

        // Only validate file if a new one is being uploaded
        if ($request->hasFile('file')) {
            $rules['file'] = 'required|file|mimes:pdf|max:2048';
        }

        $validated = $request->validate($rules, [
            'id_thn.required' => 'Tahun harus diisi',
            'id_thn.integer' => 'Tahun harus berupa angka',
            'semester.required' => 'Semester harus diisi',
            'semester.max' => 'Semester maksimal 20 karakter',
            'nama.required' => 'Nama harus diisi',
            'nama.max' => 'Nama maksimal 200 karakter',
            'file.required' => 'File harus diupload',
            'file.file' => 'File tidak valid',
            'file.mimes' => 'File harus berformat PDF',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $updateData = [
                'id_thn' => $validated['id_thn'],
                'semester' => $validated['semester'],
                'nama' => $validated['nama'],
            ];

            // Handle file upload if new file is provided
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Delete old file if exists
                $oldFilePath = public_path('uploads/final/' . $final->file);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Upload new file
                $file->move(public_path('uploads/final'), $fileName);
                $updateData['file'] = $fileName;
            }

            $final->update($updateData);

            return redirect()->route('final-calender.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Sukses',
                'detail' => 'Jadwal final berhasil diperbarui',
                'life' => 3000
            ]);

        } catch (\Exception $e) {
            // If new file was uploaded but update failed, clean it up
            if (isset($fileName) && file_exists(public_path('uploads/final/' . $fileName))) {
                unlink(public_path('uploads/final/' . $fileName));
            }

            return back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Terjadi kesalahan saat memperbarui data',
                'life' => 3000
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $final = FinalCalender::findOrFail($id);

            // Delete the associated file if it exists
            $filePath = public_path('uploads/final/' . $final->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete the record
            $final->delete();

            return redirect()->route('final-calender.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Sukses',
                'detail' => 'Jadwal final berhasil dihapus',
                'life' => 3000
            ]);
        } catch (\Exception $e) {
            return back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Terjadi kesalahan saat menghapus data',
                'life' => 3000
            ]);
        }
    }
}
