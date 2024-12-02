<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Kalender;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KalenderController extends Controller
{
    public function index(Request $request)
    {
        $kalender = Kalender::query()
            ->with('document')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('thnajr', 'like', "%{$search}%");
            })
            ->orderBy('tgl_upload', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Kalender/Index', [
            'kalender' => $kalender,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        $documents = Document::select('id', 'nama_file as label')
            ->orderBy('nama_file')
            ->get()
            ->map(function ($doc) {
                return [
                    'value' => $doc->id,
                    'label' => $doc->label
                ];
            });

        return Inertia::render('Kalender/Create', [
            'documents' => $documents
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'thnajr' => 'required|max:100',
            'nama' => 'required|max:200',
            'upload_id' => 'required|exists:upload,id',
        ]);

        try {
            DB::beginTransaction();

            Kalender::create([
                'thnajr' => $request->thnajr,
                'nama' => $request->nama,
                'upload_id' => $request->upload_id,
                'tgl_upload' => now(),
            ]);

            DB::commit();

            return redirect()->route('kalender.index')->with('message', [
                'type' => 'success',
                'text' => 'Kalender berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function edit(Kalender $kalender)
    {
        $documents = Document::select('id', 'nama_file as label')
            ->orderBy('nama_file')
            ->get()
            ->map(function ($doc) {
                return [
                    'value' => $doc->id,
                    'label' => $doc->label
                ];
            });

        return Inertia::render('Kalender/Edit', [
            'kalender' => $kalender->load('document'),
            'documents' => $documents
        ]);
    }

    public function update(Request $request, Kalender $kalender)
    {
        $request->validate([
            'thnajr' => 'required|max:100',
            'nama' => 'required|max:200',
            'upload_id' => 'required|exists:upload,id',
        ]);

        try {
            DB::beginTransaction();

            $kalender->update([
                'thnajr' => $request->thnajr,
                'nama' => $request->nama,
                'upload_id' => $request->upload_id,
                'tgl_upload' => now(),
            ]);

            DB::commit();

            return redirect()->route('kalender.index')->with('message', [
                'type' => 'success',
                'text' => 'Kalender berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(Kalender $kalender)
    {
        try {
            DB::beginTransaction();
            $kalender->delete();
            DB::commit();

            return redirect()->route('kalender.index')->with('message', [
                'type' => 'success',
                'text' => 'Kalender berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function download(Kalender $kalender)
    {
        if (!$kalender->document) {
            abort(404, 'File tidak ditemukan');
        }

        $fullPath = storage_path('app/public/' . $kalender->document->path);

        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan di storage');
        }

        return response()->download(
            $fullPath,
            $kalender->document->nama_file . '.' . pathinfo($kalender->document->path, PATHINFO_EXTENSION)
        );
    }
}
