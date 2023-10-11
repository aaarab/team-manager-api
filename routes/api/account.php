<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AccountController;


Route::apiResource('account', AccountController::class)->middleware('auth:api');
