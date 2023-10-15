<?php

namespace Tests\Feature;

use App\Models\Employer;
use App\Models\User;
use App\Traits\HasTest;
use Tests\TestCase;

class EmployerTest extends TestCase
{
    use HasTest;

    protected $model = Employer::class;
    protected $api = '/employer';
    protected $user;
    protected $count;
    protected $countWithTrashed;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::findOrFail(1);
        $this->count = count(Employer::all());
        $this->countWithTrashed = count(Employer::withTrashed()->get());
    }
}
