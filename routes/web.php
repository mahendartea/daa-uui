<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
        Route::group(['prefix' => 'galeries'], function () {
            Route::get('/', [GaleryController::class, 'index'])->name('galeries.index');
            Route::delete('destroy/{galery}', [GaleryController::class, 'destroy'])->name('galeries.destroy');
            Route::get('create', [GaleryController::class, 'create'])->name('galeries.create');
            Route::post('store', [GaleryController::class, 'store'])->name('galeries.store');
            Route::get('edit/{galery}', [GaleryController::class, 'edit'])->name('galeries.edit');
            Route::put('update/{galery}', [GaleryController::class, 'update'])->name('galeries.update');
        });
        Route::group(['prefix' => 'albums'], function () {
            Route::get('/', [AlbumController::class, 'index'])->name('albums.index');
            Route::get('create', [AlbumController::class, 'create'])->name('albums.create');
            Route::post('store', [AlbumController::class, 'store'])->name('albums.store');
            Route::get('edit/{album}', [AlbumController::class, 'edit'])->name('albums.edit');
            Route::put('update/{album}', [AlbumController::class, 'update'])->name('albums.update');
            Route::delete('destroy/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');
        });
    });
});
