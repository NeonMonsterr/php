<?php

namespace Database\Seeders;
use App\Models\PharmacyStaff;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PharmacyStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PharmacyStaff::factory()->count(20)->create();
    }
}
