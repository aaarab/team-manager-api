<?php

namespace App\Models;

use App\Models\Scopes\EmployerScope;
use App\Traits\HasModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employer extends Model
{
    use HasFactory;
    use HasModel;

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new EmployerScope());
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'account_id',
        'user_id',
        'status',
    ];


    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'bail|required|string|unique:employers,email,' . $this->id,
            'account_id' => 'required|integer',
            'user_id' => 'required|integer',
            'status' => 'required|string|in:draft,valid,cancelled',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function bootUpdating()
    {
        if ($this->original['status'] === 'valid' && $this->status === 'cancelled') {
            $this->status = 'valid';
        }
    }

    public function bootUpdated()
    {
        if ($this->status === 'cancelled') {
            $user = $this->user;
            $user->delete();
        }

    }
}
