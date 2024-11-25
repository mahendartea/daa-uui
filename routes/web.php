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
        Route::group(['prefix' => 'posts'], function () {
            Route::get('/', [PostController::class, 'index'])->name('posts.index');
            Route::get('create', [PostController::class, 'create'])->name('posts.create');
            Route::post('store', [PostController::class, 'store'])->name('posts.store');
            Route::post('store-draft', [PostController::class, 'storeDraft'])->name('posts.store-draft');
            Route::delete('destroy/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
            Route::get('edit/{post}', [PostController::class, 'edit'])->name('posts.edit');
            Route::put('update/{post}', [PostController::class, 'update'])->name('posts.update');
            Route::put('publish/{post}', [PostController::class, 'publish'])->name('posts.publish');
            Route::put('update-draft/{post}', [PostController::class, 'updateDraft'])->name('posts.update-draft');
            Route::get('show/{post}', [PostController::class, 'show'])->name('posts.show');
        });
    });
});
