<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employer::factory()->times(20)->create()->each(function ($employer) {
           User::factory()->create([
              'email' => $employer->email,
              'password' => Hash::make('123456789'),
           ]);
        });
    }
}
