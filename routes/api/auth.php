<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, "login"])->name('login');

Route::get('/logout', [AuthController::class, "logout"])
    ->middleware('auth:api')
    ->name("logout");
