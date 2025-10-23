<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@postingdasi.local'],
            [
                'name' => 'Admin Backend',
                'password' => Hash::make('Admin#123456'),
            ]
        );
    }
}
