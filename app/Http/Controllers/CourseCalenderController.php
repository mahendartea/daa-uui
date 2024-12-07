<?php

namespace App\Http\Controllers;

use App\Models\CourseCalender;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class CourseCalenderController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseCalender::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                  ->orWhere('semester', 'like', "%{$searchTerm}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $courseCalenders = $query->orderBy('created_at', 'desc')
                                ->paginate($perPage)
                                ->withQueryString();

        return Inertia::render('CourseCalender/Index', [
            'courseCalenders' => $courseCalenders,
            'message' => session('message')
        ]);
    }

    public function create()
    {
        return Inertia::render('CourseCalender/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_thn' => 'required|integer',
            'semester' => 'required|string|max:20',
            'nama' => 'required|string|max:200',
            'file' => 'required|file|max:2048'
        ]);

        $file = $request->file('file');
        $path = $file->store('course-calendars', 'public');

        CourseCalender::create([
            'id_thn' => $request->id_thn,
            'semester' => $request->semester,
            'nama' => $request->nama,
            'file' => $path,
            'tgl_upload' => now()
        ]);

        return redirect()->route('course-calendar.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Success',
            'detail' => 'Course calendar created successfully',
            'life' => 3000
        ]);
    }

    public function edit(CourseCalender $courseCalender)
    {
        return Inertia::render('CourseCalender/Edit', [
            'courseCalender' => $courseCalender
        ]);
    }

    public function update(Request $request, CourseCalender $courseCalender)
    {
        // Validate non-file fields first
        $request->validate([
            'id_thn' => 'required|integer',
            'semester' => 'required|string|max:20',
            'nama' => 'required|string|max:200',
        ]);

        // Only validate file if a new one is being uploaded
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|file|max:2048|mimes:pdf,doc,docx,xls,xlsx'
            ], [
                'file.max' => 'Ukuran file tidak boleh lebih dari 2MB',
                'file.mimes' => 'Format file harus PDF, DOC, DOCX, XLS, atau XLSX'
            ]);
        }

        try {
            $data = $request->only(['id_thn', 'semester', 'nama']);

            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($courseCalender->file) {
                    Storage::disk('public')->delete($courseCalender->file);
                }

                // Store new file
                $file = $request->file('file');
                $data['file'] = $file->store('course-calendars', 'public');
                $data['tgl_upload'] = now();
            } elseif ($request->input('file') === null && $courseCalender->file) {
                // If file field is explicitly set to null, remove the existing file
                Storage::disk('public')->delete($courseCalender->file);
                $data['file'] = null;
                $data['tgl_upload'] = null;
            }
            // If no file is provided and file field is not null, keep the existing file

            $courseCalender->update($data);

            return redirect()->route('course-calendar.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Jadwal kuliah berhasil diperbarui',
                'life' => 3000
            ]);
        } catch (\Exception $e) {
            return back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Terjadi kesalahan saat memperbarui jadwal',
                'life' => 3000
            ]);
        }
    }

    public function destroy(CourseCalender $courseCalender)
    {
        try {
            // Get the file path before deleting the record
            $filePath = $courseCalender->file;

            // Delete the record first
            $courseCalender->delete();

            // If file exists, delete it from storage
            if ($filePath) {
                try {
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                } catch (\Exception $e) {
                    // Log error but don't stop the process since record is already deleted
                    logger()->error('Failed to delete file: ' . $filePath . '. Error: ' . $e->getMessage());
                }
            }

            return redirect()->route('course-calendar.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Jadwal kuliah berhasil dihapus',
                'life' => 3000
            ]);
        } catch (\Exception $e) {
            return redirect()->route('course-calendar.index')->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Terjadi kesalahan saat menghapus jadwal',
                'life' => 3000
            ]);
        }
    }
}
