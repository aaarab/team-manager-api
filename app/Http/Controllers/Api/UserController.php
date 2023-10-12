<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\User;
use App\Traits\HasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HasController;

    protected $model = User::class;

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

        $isFirstUpdate = strtotime($user->created_at) === strtotime($user->updated_at);

        if($request->has('password') && !empty($request->password)) {
            $input->password = Hash::make($request->password);
        }

        $user->fill($input);
        $user->save();
        if (
            $isFirstUpdate
            && $user->hasRole('user')
        ) {
            $employer = Employer::whereUserId($user->id)->first();
            $employer->status = 'valid';
            $employer->save();
            $user->givePermissionTo(['employers.index']);
        }

        return $user;
    }
}
