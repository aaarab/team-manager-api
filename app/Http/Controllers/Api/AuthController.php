<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);

        if ($validation->fails()):
            return response()->json($validation->errors(), 422);
        endif;

        $user_credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($user_credentials)) :
            $user = Auth::user();
            $user_access_token = $user->createToken('api-auth')->accessToken;
            return response()->json(['token' => $user_access_token, 'email' => $user->email], 200);
        endif;

        return response()->json(['message' => 'Unauthorized Access: invalid email or password, please try again '], 401);

    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['message' => 'logout successfully']);
        }

        return response()->json(['message' => 'unable to logout']);
    }
}
