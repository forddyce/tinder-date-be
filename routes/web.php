<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug', function () {
    return response()->json([
        'routes' => collect(Route::getRoutes())->map(fn($route) => [
            'uri' => $route->uri(),
            'methods' => $route->methods(),
        ])->values(),
        'env' => [
            'APP_ENV' => env('APP_ENV'),
            'APP_DEBUG' => env('APP_DEBUG'),
        ]
    ]);
});
