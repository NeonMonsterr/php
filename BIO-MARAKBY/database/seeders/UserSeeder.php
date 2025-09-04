<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Teacher
        User::firstOrCreate(
            ['email' => 'mohamed@bioacademy.com'],
            [
                'name' => 'Mr. Mohamed Marakby',
                'password' => Hash::make('marakby123456789'),
                'role' => 'teacher',
            ]
        );

        // Student
        User::firstOrCreate(
            ['email' => 'ahmed@student.com'],
            [
                'name' => 'Ahmed Ayman',
                'password' => Hash::make('student123456789'),
                'role' => 'student',
            ]
        );
    }
}
