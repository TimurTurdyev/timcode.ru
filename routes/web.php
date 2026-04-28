<?php

use App\Http\Controllers\CaseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/json', [HomeController::class, 'json']);
Route::get('/cases/{slug}', [CaseController::class, 'show'])->where('slug', '[a-z0-9\-]+');

Route::get('/contact', [ContactController::class, 'show']);
Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:5,1');
