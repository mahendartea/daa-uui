<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
            Route::get('create', [CategoryController::class, 'createCategory'])->name('categories.create');
            Route::post('store', [CategoryController::class, 'storeCategory'])->name('categories.store');
            Route::delete('destroy/{category}', [CategoryController::class, 'destroyCategory'])->name('categories.destroy');
            Route::get('edit/{category}', [CategoryController::class, 'editCategory'])->name('categories.edit');
            Route::put('update/{category}', [CategoryController::class, 'updateCategory'])->name('categories.update');
        });

        Route::group(['prefix' => 'agenda'], function () {
            Route::get('/', [AgendaController::class, 'index'])->name('agenda.index');
            Route::get('create', [AgendaController::class, 'create'])->name('agenda.create');
            Route::post('/', [AgendaController::class, 'store'])->name('agenda.store');
            Route::delete('destroy/{agenda}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
            Route::get('edit/{agenda}', [AgendaController::class, 'edit'])->name('agenda.edit');
            Route::put('update/{agenda}', [AgendaController::class, 'update'])->name('agenda.update');
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
        Route::group(['prefix' => 'documents'], function () {
            Route::get('/', [DocumentController::class, 'index'])->name('documents.index');
            Route::get('create', [DocumentController::class, 'create'])->name('documents.create');
            Route::post('store', [DocumentController::class, 'store'])->name('documents.store');
            Route::get('show/{document}', [DocumentController::class, 'show'])->name('documents.show');
            Route::get('{document}/view', [DocumentController::class, 'viewDocument'])->name('documents.view');
            Route::get('{document}/download', [DocumentController::class, 'downloadDocument'])->name('documents.download');
            Route::get('edit/{document}', [DocumentController::class, 'edit'])->name('documents.edit');
            Route::put('update/{document}', [DocumentController::class, 'update'])->name('documents.update');
            Route::delete('destroy/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::get('create', [UserController::class, 'create'])->name('users.create');
            Route::post('store', [UserController::class, 'store'])->name('users.store');
            Route::delete('destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::get('edit/{user}', [UserController::class, 'edit'])->name('users.edit');
            Route::put('update/{user}', [UserController::class, 'update'])->name('users.update');
            Route::get('show/{user}', [UserController::class, 'show'])->name('users.show');
        });
    });
});
