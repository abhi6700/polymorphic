<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

## Auth
Route::post('/login', [AuthController::class, 'login']);

// middle ware
Route::middleware(['auth:sanctum'])->group(function () {
    ## Post
    Route::get('/post', [PostController::class, 'index']);
    Route::post('/post', [PostController::class, 'store']);
    Route::get('/post/{id}', [PostController::class, 'show']);
    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::delete('/post/{id}', [PostController::class, 'destroy']);

    ## Comment
    Route::get('/post/{post}/comments', [CommentController::class, 'index']);
    Route::post('/comment', [CommentController::class, 'store']);
    Route::get('/comment/{id}', [CommentController::class, 'show']);
    Route::put('/comment/{id}', [CommentController::class, 'update']);
    Route::delete('/comment/{id}', [CommentController::class, 'destroy']);

});