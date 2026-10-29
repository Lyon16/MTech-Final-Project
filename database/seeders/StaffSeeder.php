<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'full_name' => 'Demo Administrator',
                'password' => Hash::make(
                    env('POS_DEMO_ADMIN_PASSWORD')
                ),
                'created_at' => now(),
            ]
        );
    }
}
