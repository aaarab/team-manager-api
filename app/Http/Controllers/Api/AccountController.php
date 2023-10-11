<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Traits\HasController;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    use HasController;

    protected $model = Account::class;
}
