<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostsController::class, 'get'])->name('posts.get');


    Route::prefix('/{post}')->group(function () {
        Route::delete('/', [PostsController::class, 'delete'])->name('posts.delete');
        Route::post('/comments', [CommentsController::class, 'create'])->name('comments.create');
        Route::get('/comments', [CommentsController::class, 'get'])->name('comments.get');
        Route::delete('/comments/{comment}', [CommentsController::class, 'delete'])->name('comments.delete');
    });
});
