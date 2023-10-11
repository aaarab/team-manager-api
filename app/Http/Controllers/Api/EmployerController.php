<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Traits\HasController;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    use HasController;

    protected $model = Employer::class;
}
