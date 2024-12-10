<?php

namespace App\Http\Controllers;

use App\Models\Statis;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatisController extends Controller
{
    /**
     * Display a listing of the static pages.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pages = Statis::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('judul_seo', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhere('tag', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Statis/Index', [
            'pages' => $pages,
            'filters' => [
                'search' => $search,
            ],
            'message' => session('message')
        ]);
    }

    /**
     * Show the form for creating a new static page.
     */
    public function create()
    {
        return Inertia::render('Statis/Create');
    }

    /**
     * Display the specified static page by slug.
     */
    public function show($slug)
    {
        $page = Statis::where('judul_seo', $slug)->firstOrFail();
        return Inertia::render('Public/Statis/Show', [
            'page' => $page
        ]);
    }

    /**
     * Show the form for editing the specified static page.
     */
    public function edit($id)
    {
        $page = Statis::findOrFail($id);
        return Inertia::render('Statis/Edit', [
            'page' => $page
        ]);
    }

    /**
     * Store a newly created static page.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'judul_seo' => 'required|string|unique:statis',
            'content' => 'required|string',
            'tag' => 'nullable|string|max:100',
            'tgl' => 'nullable|date'
        ]);

        Statis::create($validated);

        return redirect()->route('statis.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Halaman statis berhasil dibuat',
            'life' => 3000
        ]);
    }

    /**
     * Update the specified static page.
     */
    public function update(Request $request, $id)
    {
        $page = Statis::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string',
            'judul_seo' => 'required|string|unique:statis,judul_seo,' . $id,
            'content' => 'required|string',
            'tag' => 'nullable|string|max:100',
            'tgl' => 'nullable|date'
        ]);

        $page->update($validated);

        return redirect()->route('statis.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Halaman statis berhasil diperbarui',
            'life' => 3000
        ]);
    }

    /**
     * Remove the specified static page.
     */
    public function destroy($id)
    {
        $page = Statis::findOrFail($id);
        $page->delete();

        return redirect()->route('statis.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Halaman statis berhasil dihapus',
            'life' => 3000
        ]);
    }
}
