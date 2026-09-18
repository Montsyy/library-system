<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/members', [MemberController::class, 'index']);