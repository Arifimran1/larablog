<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    // Other admin routes
});

Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/editor', [EditorController::class, 'index'])->name('editor.dashboard');
    // Other editor routes
});

Route::middleware(['auth', 'role:author'])->group(function () {
    Route::get('/author', [AuthorController::class, 'index'])->name('author.dashboard');
    // Other author routes
});

Route::resource('posts', PostController::class)->parameters([
    'posts' => 'post:slug'
])->middleware('auth');

Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

