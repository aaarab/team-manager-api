<?php

namespace App\Models;

use App\Traits\HasModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasModel;
    use HasRoles;
    use HasApiTokens, HasFactory;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'birthday',
        'password',
        'account_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'bail|required|email|unique:users,email,' . $this->id,
            'password' => 'nullable|string|max:150|min:9',
            'phone' => 'nullable|string',
            'birthday' => 'nullable|date',
            'account_id' => 'nullable|integer'
        ];
    }


    public function bootCreated()
    {
        if(request()->has('roles') && !empty(request()->roles)) {
            $this->assignRole(request()->roles);
        }
    }

//    public function bootUpdated()
//    {
//        if (
//            $this->original['created_at'] === $this->original['updated_at']
//            && $this->hasRole('user')
//        ) {
//            $employer = Employer::whereEmail($this->original['email'])->first();
//            $employer->status = 'valid';
//            $employer->save();
//            $this->givePermissionTo(['employers.index']);
//        }
//    }

}
