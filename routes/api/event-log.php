<?php

use App\Http\Controllers\Api\EventLogController;
use Illuminate\Support\Facades\Route;

Route::get('/event-log', [EventLogController::class, 'index'])
    ->middleware('auth:api')
    ->name('event-log.index');
