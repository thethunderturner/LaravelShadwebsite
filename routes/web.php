<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CompatibilityController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DownloadRedirectController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/compatibility', CompatibilityController::class)->name('compatibility');
Route::get('/downloads', DownloadController::class)->name('downloads');
Route::get('/downloads/{download}/go', DownloadRedirectController::class)->name('downloads.go');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
