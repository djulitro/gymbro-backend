<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Necesito retornar un JSON saludando al usuario diciendo que es el gymbro backend
    return response()->json([
        'message' => 'Welcome to Gymbro Backend'
    ]);
});
