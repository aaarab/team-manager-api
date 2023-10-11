<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HasController;

class UserController extends Controller
{
    use HasController;

    protected $model = User::class;
}
