<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseCalenderController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FinalCalenderController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\HeadlineController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\MidtemCalenderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatisController;
use App\Http\Controllers\UserController;
use App\Models\CourseCalender;
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
    return Inertia::render('Public/Home/Home', [
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

    Route::prefix('admin')->group(function () {
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

        Route::group(['prefix' => 'course-calendar'], function () {
            Route::get('/', [CourseCalenderController::class, 'index'])->name('course-calendar.index');
            Route::get('create', [CourseCalenderController::class, 'create'])->name('course-calendar.create');
            Route::post('/', [CourseCalenderController::class, 'store'])->name('course-calendar.store');
            Route::delete('{courseCalender}', [CourseCalenderController::class, 'destroy'])->name('course-calendar.destroy');
            Route::get('{courseCalender}/edit', [CourseCalenderController::class, 'edit'])->name('course-calendar.edit');
            Route::put('{courseCalender}', [CourseCalenderController::class, 'update'])->name('course-calendar.update');
        });

        Route::group(['prefix' => 'midtem-calender'], function () {
            Route::get('/', [MidtemCalenderController::class, 'index'])->name('midtem-calender.index');
            Route::get('create', [MidtemCalenderController::class, 'create'])->name('midtem-calender.create');
            Route::post('/', [MidtemCalenderController::class, 'store'])->name('midtem-calender.store');
            Route::get('{midtemCalender}/edit', [MidtemCalenderController::class, 'edit'])->name('midtem-calender.edit');
            Route::put('{midtemCalender}', [MidtemCalenderController::class, 'update'])->name('midtem-calender.update');
            Route::delete('{midtemCalender}', [MidtemCalenderController::class, 'destroy'])->name('midtem-calender.destroy');
        });

        Route::group(['prefix'=>'final-calender'], function () {
            Route::get('/', [FinalCalenderController::class, 'index'])->name('final-calender.index');
            Route::get('create', [FinalCalenderController::class, 'create'])->name('final-calender.create');
            Route::post('/', [FinalCalenderController::class, 'store'])->name('final-calender.store');
            Route::delete('{finalCalender}', [FinalCalenderController::class, 'destroy'])->name('final-calender.destroy');
            Route::get('{finalCalender}/edit', [FinalCalenderController::class, 'edit'])->name('final-calender.edit');
            Route::put('{finalCalender}', [FinalCalenderController::class, 'update'])->name('final-calender.update');
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

        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles.index');
            Route::get('create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('store', [RoleController::class, 'store'])->name('roles.store');
            Route::delete('destroy/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
            Route::get('edit/{role}', [RoleController::class, 'edit'])->name('roles.edit');
            Route::put('update/{role}', [RoleController::class, 'update'])->name('roles.update');
        });

        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('create', [PermissionController::class, 'create'])->name('permissions.create');
            Route::post('store', [PermissionController::class, 'store'])->name('permissions.store');
            Route::delete('destroy/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
            Route::get('edit/{permission}', [PermissionController::class, 'edit'])->name('permissions.edit');
            Route::put('update/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        });

        Route::group(['prefix' => 'akademik'], function () {
            Route::get('/', [KalenderController::class, 'index'])->name('kalender.index');
            Route::get('create', [KalenderController::class, 'create'])->name('kalender.create');
            Route::post('store', [KalenderController::class, 'store'])->name('kalender.store');
            Route::delete('destroy/{kalender}', [KalenderController::class, 'destroy'])->name('kalender.destroy');
            Route::get('edit/{kalender}', [KalenderController::class, 'edit'])->name('kalender.edit');
            Route::put('update/{kalender}', [KalenderController::class, 'update'])->name('kalender.update');
            Route::get('download/{kalender}', [KalenderController::class, 'download'])->name('kalender.download');
        });

        // Headline Routes
        Route::get('/headline', [HeadlineController::class, 'index'])->name('headline.index');
        Route::get('/headline/create', [HeadlineController::class, 'create'])->name('headline.create');
        Route::post('/headline', [HeadlineController::class, 'store'])->name('headline.store');
        Route::get('/headline/{id}/edit', [HeadlineController::class, 'edit'])->name('headline.edit');
        Route::put('/headline/{id}', [HeadlineController::class, 'update'])->name('headline.update');

        // Static Pages Management Routes
        Route::group(['prefix' => 'statis'], function () {
            Route::get('/', [StatisController::class, 'index'])->name('statis.index');
            Route::get('create', [StatisController::class, 'create'])->name('statis.create');
            Route::post('store', [StatisController::class, 'store'])->name('statis.store');
            Route::get('{id}/edit', [StatisController::class, 'edit'])->name('statis.edit');
            Route::put('{id}', [StatisController::class, 'update'])->name('statis.update');
            Route::delete('{id}', [StatisController::class, 'destroy'])->name('statis.destroy');
        });
    });
});

// Public Routes
Route::get('pages/{slug}', [StatisController::class, 'show'])->name('statis.show');

Route::get('/posts/public', [PostController::class, 'getPublicPosts'])->name('posts.public');
Route::get('/post/{seo}', [PostController::class, 'showPublic'])->name('post.show');
Route::get('/posts', [PostController::class, 'showAllPublic'])->name('posts.showAllPublic');

Route::get('/agenda/latest', [AgendaController::class, 'showlatestagenda'])->name('agenda.latest');
Route::get('/agenda/{id}', [AgendaController::class, 'showPublic'])->name('agenda.show');
Route::get('/agenda', [AgendaController::class, 'showAllPublic'])->name('agenda.showAllPublic');
