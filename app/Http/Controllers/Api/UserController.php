<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserRegisteredMail;
use App\Models\Employer;
use App\Models\User;
use App\Traits\HasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use HasController { store as storeFromTrait; }

    protected $model = User::class;

    public function store(Request $request)
    {
        $password =  env('APP_ENV') === 'production'
            ? Str::random(9)
            : '123456789';

        $input = $request->merge(['password' => $password]);
        $user = $this->storeFromTrait($input);

        if(request()->has('roles') && !empty(request()->roles)) {
            $user->assignRole(request()->roles);
        }

        $details = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'url' => env('CLIENT_URL') . "/auth/login"
        ];

        try {
            $mail = new UserRegisteredMail($details);
            Mail::to($user->email)->send($mail);
        } catch (Exception $e) {
        }

        return $user;
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

        $isFirstUpdate = strtotime($user->created_at) === strtotime($user->updated_at);

        if($request->has('password') && !empty($request->password)) {
            $input['password'] = Hash::make($request->password);
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
