<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\MidtemCalender;

class MidtemCalenderController extends Controller
{
    public function index()
    {
        $midterms = MidtemCalender::orderBy('tgl_upload', 'desc')->get();
        return Inertia::render('MidtemCalender/Index', [
            'midterms' => $midterms,
            'message' => session('message')
        ]);
    }

    public function create()
    {
        return Inertia::render('MidtemCalender/Create');
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
            $file->move(public_path('uploads/midterm'), $fileName);

            MidtemCalender::create([
                'id_thn' => $validated['id_thn'],
                'semester' => $validated['semester'],
                'nama' => $validated['nama'],
                'file' => $fileName,
                'tgl_upload' => now()
            ]);

            return redirect()->route('midtem-calender.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Success',
                'detail' => 'Jadwal midterm berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            // If file was uploaded but create failed, clean it up
            if (isset($fileName)) {
                $newFile = public_path('uploads/midterm/' . $fileName);
                if (file_exists($newFile)) {
                    unlink($newFile);
                }
            }

            return back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }

    public function edit(MidtemCalender $midtemCalender)
    {
        return Inertia::render('MidtemCalender/Edit', [
            'midterm' => $midtemCalender
        ]);
    }

    public function update(Request $request, MidtemCalender $midtemCalender)
    {
        $rules = [
            'id_thn' => 'required|integer',
            'semester' => 'required|string|max:20',
            'nama' => 'required|string|max:200',
        ];

        // Only validate file if it's being updated
        if ($request->hasFile('file')) {
            $rules['file'] = 'required|file|mimes:pdf|max:2048';
        }

        $messages = [
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
        ];

        try {
            $validated = $request->validate($rules, $messages);

            $data = [
                'id_thn' => $validated['id_thn'],
                'semester' => $validated['semester'],
                'nama' => $validated['nama'],
            ];

            if ($request->hasFile('file')) {
                // Delete old file
                if ($midtemCalender->file) {
                    $oldFile = public_path('uploads/midterm/' . $midtemCalender->file);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                // Upload new file
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/midterm'), $fileName);
                $data['file'] = $fileName;
                $data['tgl_upload'] = now();
            }

            $midtemCalender->update($data);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Jadwal midterm berhasil diperbarui'
                ]);
            }

            return redirect()->route('midtem-calender.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Sukses',
                'detail' => 'Jadwal midterm berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            // If file was uploaded but update failed, clean it up
            if (isset($fileName)) {
                $newFile = public_path('uploads/midterm/' . $fileName);
                if (file_exists($newFile)) {
                    unlink($newFile);
                }
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
                ], 422);
            }

            return back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroy(MidtemCalender $midtemCalender)
    {
        if ($midtemCalender->file) {
            $file = public_path('uploads/midterm/' . $midtemCalender->file);
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $midtemCalender->delete();

        return redirect()->route('midtem-calender.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Success',
            'detail' => 'Jadwal midterm berhasil dihapus',
        ]);
    }
}
