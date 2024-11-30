<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('created_at')->orderByDesc('updated_at')->get();
        return Inertia::render('Category/index', [
            'categories' => $categories,
            'message' => session('message')
        ]);
    }

    public function createCategory()
    {
        return Inertia::render('Category/Create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100',
            'aktif' => 'required|in:Y,N'
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Kategori berhasil ditambahkan',
            'life' => 3000
        ]);
    }

    public function editCategory(Category $category)
    {
        return Inertia::render('Category/Edit', [
            'category' => $category
        ]);
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100',
            'aktif' => 'required|in:Y,N'
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Kategori berhasil diperbarui',
            'life' => 3000
        ]);
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Kategori berhasil dihapus',
            'life' => 3000
        ]);
    }
}
