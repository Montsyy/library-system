<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books', [BookController::class, 'index']);
Route::get('/categories/{id}', [CategoriesController::class, 'show']);
Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/members/{id}', [MemberController::class, 'show']);
Route::get('/members', [MemberController::class, 'index']);