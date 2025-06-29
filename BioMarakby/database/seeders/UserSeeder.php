<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Teachers
        User::create([
            'name' => 'Mr. Mohamed Marakby',
            'email' => 'mohamed@bioacademy.com',
            'password' => Hash::make('marakby123456789'),
            'role' => 'teacher',
        ]);


    }
}
