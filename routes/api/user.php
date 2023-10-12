<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


Route::put('/user-profile', [UserController::class, 'updateProfile'])
    ->middleware('auth:api')
    ->name('user.profile');

Route::apiResource('user', UserController::class)->middleware('auth:api');

