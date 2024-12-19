<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'index']);
Route::get('/articles', [ArticleController::class, 'catalog']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
