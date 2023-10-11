<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployerController;


Route::apiResource('employer', EmployerController::class)->middleware('auth:api');
