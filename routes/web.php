<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactUsFormController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile');

    //Comments
    Route::post('comments.store', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    //Like
    Route::post('/like/{photo}', [PhotoController::class, 'like'])->name('like');
    Route::post('/dislike/{photo}', [PhotoController::class, 'dislike'])->name('dislike');

    //Photo
    Route::get('/photos/create', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    Route::get('/photos/tag/{tag}', [PhotoController::class, 'getPhotosByTag'])->name('photos.tag');

    //Contact
    Route::get('/contact', [ContactUsFormController::class, 'createForm'])->name('contact');
    Route::post('/contact', [ContactUsFormController::class, 'ContactUsForm'])->name('contact.store');
});
//Users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('users/search', [UserController::class, 'search'])->name('users.search');

// Photos
Route::get('/', [PhotoController::class, 'index'])->name('photos.index');
Route::get('/photos', [PhotoController::class, 'photos'])->name('photos.photos');
Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
Route::get('/search', [PhotoController::class, 'search'])->name('photos.search');

//Admin
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    Route::get('/photos', [AdminController::class, 'photos'])->name('admin-photos');
    Route::delete('/photos/{id}', [AdminController::class, 'deletePhoto'])->name('admin.deletePhoto');
    Route::get('/users', [AdminController::class, 'getUsers'])->name('admin.users');
    Route::get('/users/{id}', [AdminController::class, 'viewPhotos'])->name('admin.view-photos');
    Route::post('/users/{user}/activate', [AdminController::class, 'activateUser'])->name('admin.activate-user');
    Route::delete('/delete-user-permanently/{id}', [AdminController::class, 'deleteUserPermanently'])->name('admin.delete-user-permanently');
    Route::post('/make-admin/{id}', [AdminController::class, 'makeAdmin'])->name('admin.make-admin');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});

Route::get('admin', [AdminController::class, 'index'])->name('admin');
Route::post('login-admin', [AdminController::class, 'login'])->name('login-admin');

