<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students', [StudentController::class , 'getStudent'])->name('index.user');

Route::get('/students/{id}', [studentController::class, 'show']);

Route::get('/students/search', [StudentController::class, 'search']);
