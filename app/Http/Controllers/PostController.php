<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $cari = request("search");
        $posts = Post::where('title', 'like', '%' . $cari . '%')
            ->orderBy('tgl', 'desc')
            ->paginate(10);
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'message' => session('message')
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Posts/Create', [
            'categories' => $categories,
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'seo' => 'required|string|max:255|unique:post,judul_seo',
            'content' => 'required|string',
            'selectedCategory.label' => 'required',
            'tag' => 'string',
        ]);

        $post = Post::create([
            'title' => $data['title'],
            'judul_seo' => $data['seo'],
            'content' => $data['content'],
            'category' => $data['selectedCategory']['label'],
            'tag' => $data['tag'],
            'draft' => false,
            'tgl' => now(),
        ]);

        return redirect()->route('posts.index');
    }

    public function storeDraft()
    {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'seo' => 'required|string|max:255|unique:post,judul_seo',
            'content' => 'required|string',
            'selectedCategory.label' => 'required',
            'tag' => 'string',
        ]);

        $post = Post::create([
            'title' => $data['title'],
            'judul_seo' => $data['seo'],
            'content' => $data['content'],
            'category' => $data['selectedCategory']['label'],
            'tag' => $data['tag'],
            'draft' => true,
            'tgl' => now(),
        ]);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return Inertia::render('Posts/Edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    public function update(Post $post)
    {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'seo' => 'required|string|max:255|unique:post,judul_seo,' . $post->id . ',id',
            'content' => 'required|string',
            'selectedCategory.label' => 'required',
            'tag' => 'string',
        ]);

        $post->update([
            'title' => $data['title'],
            'judul_seo' => $data['seo'],
            'content' => $data['content'],
            'category' => $data['selectedCategory']['label'],
            'tag' => $data['tag'],
            'tgl' => now(),
        ]);

        return redirect()->route('posts.index')->with('message', [
            'severity' => 'success',
            'summary' => 'Berhasil',
            'detail' => 'Post berhasil diperbarui',
            'life' => 3000
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
