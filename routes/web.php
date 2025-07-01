<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Http\Middleware\Auth;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});
Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});

Route::middleware(Auth::class)->group(function () {
    Route::get('/user/dashboard', function () {
        return view('dashboard.dashboard', ['title' => 'Dashboard', 'posts' => Post::latest()->paginate(20)]);
    })->name('dashboard');
    Route::get('/user/post', [PostController::class, 'create'])->name('post.create');
    Route::post('/user/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/user/post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('/user/post/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/user/post/{id}', [PostController::class, 'update'])->name('post.update');
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact']);
});
Route::get('/posts/{post:slug}', [PostController::class, 'show']);

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');