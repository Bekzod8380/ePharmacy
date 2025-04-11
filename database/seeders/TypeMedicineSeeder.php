<?php

namespace Database\Seeders;

use App\Models\TypeMedicine;
use Illuminate\Database\Seeder;

class TypeMedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeMedicine::create(
            [
                'name' => 'Ukol'
            ]
        );
        TypeMedicine::create(
            [
                'name' => 'Tabletka'
            ]
        );
        TypeMedicine::create(
            [
                'name' => 'Sirop'
            ]
        );
        TypeMedicine::create(
            [
                'name' => 'Osma ukol'
            ]
        );
    }
}
