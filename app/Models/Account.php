<?php

namespace App\Models;

use App\Traits\HasModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    use HasModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
    ];


    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|unique:accounts,email,' . $this->id,
        ];
    }

    public function employers()
    {
        return $this->hasMany(Employer::class);
    }

}
