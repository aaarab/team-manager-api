<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EmployerCreatedMail;
use App\Models\Employer;
use App\Models\User;
use App\Traits\HasController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmployerController extends Controller
{
    use HasController { store as storeFromTrail; }

    protected $model = Employer::class;

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            // HINT: we create a user without assign Permissions To Him.
            $user = new User();
            $password = Str::random(9);
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'account_id' => $request->account_id,
            ]);

            $user->save();
            $user->assignRole('user');

            $input = $request->merge(['user_id' => $user->id]);
            $employer = $this->storeFromTrail($input);

            if (env('APP_ENV') === 'production') {
                $details = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $password,
                    'url' => env('CLIENT_URL') . "/auth/login"
                ];
                try {
                    $mail = new EmployerCreatedMail($details);
                    Mail::to($user->email)->send($mail);
                } catch (Exception $e) {
                }
            }

            return $employer;
        });
    }

}
