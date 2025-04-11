<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@unusual.uz',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $doctor = User::create([
            'name' => 'Doctor 1',
            'email' => 'doctor1@unusual.uz',
            'password' => Hash::make('password'),
        ]);
        $doctor->assignRole('doctor');

        $pharmacist = User::create([
            'name' => 'Pharmacist 1',
            'email' => 'pharmacist1@unusual.uz',
            'password' => Hash::make('password'),
            'address' => "Urganch tumani",
        ]);
        $pharmacist->assignRole('pharmacist');
    }
}
