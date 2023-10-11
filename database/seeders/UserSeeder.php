<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'demo',
            'email' => 'admin@tersea.com',
            'password' => Hash::make('123456789')
        ]);

        $admin->assignRole('admin');

        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@tersea.com',
            'password' => Hash::make('123456789')
        ]);

        $user->assignRole('user');
    }
}
