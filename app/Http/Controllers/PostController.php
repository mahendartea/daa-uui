<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $cari = request('search');
        $posts = Post::where('title', 'like', '%' . $cari . '%')
            ->orderBy('tgl', 'desc')
            ->paginate(10);
        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'message' => session('message'),
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
            'created' => request()->user()->name,
        ]);

        return redirect()
            ->route('posts.index')
            ->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Post berhasil disimpan',
                'life' => 3000,
            ]);
    }

    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Posts/Create', [
            'categories' => $categories,
        ]);
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

    public function publish(Post $post)
    {
        $post->update([
            'draft' => false,
        ]);
        return redirect()
            ->route('posts.index')
            ->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Post berhasil diterbitkan',
                'life' => 3000,
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

        return redirect()
            ->route('posts.index')
            ->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Post berhasil diperbarui',
                'life' => 3000,
            ]);
    }

    public function updateDraft(Post $post)
    {
        $post->update([
            'draft' => true,
        ]);
        return redirect()
            ->route('posts.index')
            ->with('message', [
                'severity' => 'success',
                'summary' => 'Berhasil',
                'detail' => 'Post berhasil disimpan sebagai draft',
                'life' => 3000,
            ]);
    }

    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', [
            'post' => $post,
        ]);
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }

    // for public
    public function showPublic($seo)
    {
        $post = Post::where('judul_seo', $seo)->firstOrFail();

        return Inertia::render('Public/Post/Single', [
            'post' => $post,
        ]);
    }

    // show all public post
    public function showAllPublic()
    {
        $category = request('category', 'Berita');
        $posts = Post::where('draft', false)
            ->where('category', $category)
            ->orderBy('tgl', 'desc')
            ->paginate(9);

        return Inertia::render('Public/Post/Index', [
            'posts' => $posts,
            'category' => $category,
            'categories' => ['Berita', 'Pengumuman']
        ]);
    }

    public function getPublicPosts()
    {
        $postsberita = Post::where('draft', false)->orderBy('tgl', 'desc')->where('category', 'Berita')->take(3)->get();

        $postpengumuman = Post::where('draft', false)->orderBy('tgl', 'desc')->where('category', 'Pengumuman')->take(3)->get();

        $posts = array_merge($postsberita->toArray(), $postpengumuman->toArray());

        $formattedPosts = array_map(function ($post) {
            $post['tgl'] = \Carbon\Carbon::parse($post['tgl'])->format('Y-m-d H:i:s');
            return $post;
        }, $posts);

        return response()->json($formattedPosts);
    }

}
