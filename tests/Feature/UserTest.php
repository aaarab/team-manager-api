<?php

namespace Tests\Feature;

use App\Models\User;
use App\Traits\HasTest;
use Tests\TestCase;

class UserTest extends TestCase
{
    use HasTest;

    protected $model = User::class;
    protected $api = '/user';
    protected $user;
    protected $count;
    protected $countWithTrashed;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::findOrFail(1);
        $this->count = count(User::all());
        $this->countWithTrashed = count(User::withTrashed()->get());
    }
}
