<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Traits\HasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployerController extends Controller
{
    use HasController { store as storeFromTrail; }

    protected $model = Employer::class;

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            // HINT: we create a user without assign Permissions To Him.
            $userController = new UserController();
            $user = $userController->store($request);
            $user->assignRole('user');

            $input = $request->merge(['user_id' => $user->id]);
            $employer = $this->storeFromTrail($input);

            return $employer;
        });
    }

}
