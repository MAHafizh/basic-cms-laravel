<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});

Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});
Route::get('/posts', [PostController::class, 'index']);

Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact']);
});
Route::get('/posts/{post:slug}', [PostController::class, 'show']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('dashboard.dashboard', ['title' => 'Dashboard', 'posts' => Post::latest()->paginate(20)]);
    })->name('dashboard');
    Route::get('/user/post', [PostController::class, 'create'])->name('post.create');
    Route::post('/user/post', [PostController::class, 'store'])->name('post.store');
    Route::delete('/user/post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('/user/post/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/user/post/{id}', [PostController::class, 'update'])->name('post.update');
});

Route::get('/login', [AuthController::class, 'indexLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'indexRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/email/verify', function () {
    return view('auth.email-verify', ['title' => 'Verify Email']);
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/login')->with('message', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/forgot-password', [App\Http\Controllers\ResetPasswordController::class, 'indexForgotPassword'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\ResetPasswordController::class, 'requestResetPassword'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\ResetPasswordController::class, 'resetPassword'])->name('password.update');