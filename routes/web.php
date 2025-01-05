<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::post(uri: '/chat', action: [ChatController::class, 'chat']);
Route::post('/gemini', [GeminiController::class, 'index']);
