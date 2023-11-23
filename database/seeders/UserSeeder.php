<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(['username' => 'admin'], [
            'password' => 'admin',
            'status' => UserStatus::ACTIVE,
            'roles' => [UserRole::ADMIN]
        ]);
    }
}
