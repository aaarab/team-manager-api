<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use App\Traits\HasTest;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use HasTest;

    protected $model = Account::class;
    protected $api = '/account';
    protected $user;
    protected $count;
    protected $countWithTrashed;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::findOrFail(1);
        $this->count = count(Account::all());
        $this->countWithTrashed = count(Account::withTrashed()->get());
    }
}
