<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Vendor One',
            'email' => 'vendor1@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'is_vendor' => true,
        ]);
    }
}
