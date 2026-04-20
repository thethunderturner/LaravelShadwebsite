<?php

use App\Http\Controllers\CompatibilityController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/compatibility', CompatibilityController::class)->name('compatibility');
