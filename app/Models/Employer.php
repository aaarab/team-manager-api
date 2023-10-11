<?php

namespace App\Models;

use App\Traits\HasModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
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
        'account_id',
        'status',
    ];


    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'bail|required|string|unique:employers,email,' . $this->id,
            'account_id' => 'required|integer',
            'status' => 'required|string|in:draft,valid,cancelled',
        ];
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
