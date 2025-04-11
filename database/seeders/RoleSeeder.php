<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $doctor = Role::create(['name' => 'doctor']);
        $pharmacist = Role::create(['name' => 'pharmacist']);

        $permissions = [
            'control users',
            'view users',

            'control medicines',
            'view medicines',

            'control patients',
            'view patients',

            'control pharmacies',
            'view pharmacies',
        ];
    }
}
