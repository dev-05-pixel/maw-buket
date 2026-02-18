<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@buket.com';

        if (!User::where('email', $email)->exists()) {
            User::create([
                'uid' => (string) Str::uuid(),
                'name' => 'Admin Buket',
                'email' => $email,
                'password' => Hash::make('Buket@2026Secure!'),
            ]);

            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin already exists.');
        }
    }
}
