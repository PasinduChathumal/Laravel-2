<?php
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('posts', PostController::class);

Route::resource('documents', DocumentController::class);