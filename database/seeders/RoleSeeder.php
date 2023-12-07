<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(['role' => UserRole::ADMIN, 'temple_id' => null], ['abilities' => ['*']]);
        Role::updateOrCreate(['role' => UserRole::USER, 'temple_id' => null], ['abilities' => []]);
    }
}