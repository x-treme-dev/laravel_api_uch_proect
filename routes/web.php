<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/photos', [PhotoController::class, 'index']);
Route::get('/photos/{id}', [PhotoController::class, 'show']);
Route::put('/photos/{id}', [PhotoController::class, 'update']);

