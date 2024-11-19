<?php

use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    route::group(['prefix' => 'admin'], function () {
        Route::get('posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
        Route::post('posts/store-draft', [PostController::class, 'storeDraft'])->name('posts.store-draft');
        Route::delete('posts/destroy/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::get('posts/edit/{post}', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('posts/update/{post}', [PostController::class, 'update'])->name('posts.update');
    });
});
