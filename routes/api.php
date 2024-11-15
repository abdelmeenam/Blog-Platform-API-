<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\AuthController;


    Route::group(['prefix' =>'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('logout' , [AuthController::class , 'logout'])->middleware('auth:api');
    });

    Route::get('/posts', [PostController::class, 'getAllPosts']);
    Route::post('/posts', action: [PostController::class, 'createPost']);
    Route::get('/posts/{id}', [PostController::class, 'getPost']);
    Route::put('/posts/{id}', [PostController::class, 'updatePost']);
    Route::delete('/posts/{id}', [PostController::class, 'deletePost']);

    Route::post('/posts/{id}/comments', [CommentController::class, 'createComment'])->middleware('auth:api');
