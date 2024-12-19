<?php

use App\Http\Controllers\API\ArticleApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/articles/{id}/like', [ArticleApiController::class, 'like']);
Route::post('/articles/{id}/view', [ArticleApiController::class, 'view']);
Route::post('/comments', [ArticleApiController::class, 'comment']);
