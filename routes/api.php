<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\LikeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/people/recommended', [PersonController::class, 'recommended']);
Route::post('/people/{person}/like', [LikeController::class, 'like']);
Route::post('/people/{person}/dislike', [LikeController::class, 'dislike']);
Route::get('/people/liked', [LikeController::class, 'likedPeople']);