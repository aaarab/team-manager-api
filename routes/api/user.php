<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


Route::apiResource('user', UserController::class)->middleware('auth:api');

