<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama_file', 'like', "%{$search}%")
                    ->orWhere('path', 'like', "%{$search}%")
                    ->orWhere('created', 'like', "%{$search}%")
                    ->orWhere('link_external', 'like', "%{$search}%");
            })
            ->orderBy('tgl_upload', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Document/Index', [
            'documents' => $documents,
            'message' => session('message')
        ]);
    }

    public function create()
    {
        return Inertia::render('Document/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_file' => 'required|string|max:150',
            'link_external' => 'nullable|url|max:255',
            'file' => [
                'required_without:link_external',
                'file',
                'max:10240', // 10MB max size
                'mimes:pdf,doc,docx',
            ],
        ]);

        try {
            if (!$request->link_external && !$request->hasFile('file')) {
                throw new \Exception('File atau Link External harus diisi');
            }

            $fileName = null;
            $path = null;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                if (!$file->isValid()) {
                    throw new \Exception('File tidak valid');
                }

                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(40) . '.' . $extension;
                $path = $file->storeAs('documents', $fileName, 'public');
            }

            Document::create([
                'nama_file' => $request->nama_file,
                'file_name' => $fileName,
                'path' => $path,
                'link_external' => $request->link_external,
                'tgl_upload' => now(),
                'created' => auth()->user()->name ?? 'System',
            ]);

            return redirect()->route('documents.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Dokumen berhasil ditambahkan',
                'life' => 3000
            ]);
        } catch (\Exception $e) {
            // If file was uploaded but database insert failed, remove the file
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return redirect()->back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Gagal menambahkan dokumen: ' . $e->getMessage(),
                'life' => 3000
            ])->withInput();
        }
    }

    public function show(Document $document)
    {
        $document = $document->toArray();
        $document['secure_url'] = Storage::url($document['path']);

        return Inertia::render('Document/View', [
            'document' => $document
        ]);
    }

    public function viewDocument(Document $document)
    {
        if ($document->link_external) {
            return redirect()->away($document->link_external);
        }

        $fullPath = storage_path('app/public/' . $document->path);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found: ' . $document->path);
        }

        return response()->file($fullPath);
    }

    public function downloadDocument(Document $document)
    {
        if ($document->link_external) {
            return redirect()->away($document->link_external);
        }

        $fullPath = storage_path('app/public/' . $document->path);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found: ' . $document->path);
        }

        return response()->download($fullPath, $document->nama_file . '.' . pathinfo($document->path, PATHINFO_EXTENSION));
    }

    public function edit(Document $document)
    {
        return Inertia::render('Document/Edit', [
            'document' => $document
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'nama_file' => 'required|string|max:150',
            'link_external' => 'nullable|url|max:255',
            'file' => [
                'nullable',
                'file',
                'max:10240', // 10MB max size
                'mimes:pdf,doc,docx',
            ],
        ]);

        try {
            $data = [
                'nama_file' => $request->nama_file,
                'tgl_upload' => now(),
                'link_external' => $request->link_external,
            ];

            // Handle file upload if a new file is provided
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                if (!$file->isValid()) {
                    throw new \Exception('File tidak valid');
                }

                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(40) . '.' . $extension;

                // Store new file
                $path = $file->storeAs('documents', $fileName, 'public');
                $data['path'] = $path;

                // Delete old file if it exists
                if ($document->path) {
                    $oldPath = storage_path('app/public/' . $document->path);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }

            // Update document record
            $document->update($data);

            return redirect()->route('documents.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Dokumen berhasil diperbarui',
                'life' => 3000
            ]);
        } catch (\Exception $e) {
            // If new file was uploaded but database update failed, remove it
            if (isset($path)) {
                $newPath = storage_path('app/public/' . $path);
                if (file_exists($newPath)) {
                    unlink($newPath);
                }
            }

            return redirect()->back()->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Gagal memperbarui dokumen: ' . $e->getMessage(),
                'life' => 3000
            ])->withInput();
        }
    }

    public function destroy(Document $document)
    {
        try {
            // Get the file path before deleting the record
            $filePath = $document->path;

            // Delete the database record first
            $document->delete();

            // Then delete the physical file if it exists
            if ($filePath) {
                $fullPath = storage_path('app/public/' . $filePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            return redirect()->route('documents.index')->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Dokumen berhasil dihapus',
                'life' => 3000
            ]);
        } catch (\Exception $e) {
            return redirect()->route('documents.index')->with('message', [
                'severity' => 'error',
                'summary' => 'Error',
                'detail' => 'Gagal menghapus dokumen: ' . $e->getMessage(),
                'life' => 3000
            ]);
        }
    }
}
