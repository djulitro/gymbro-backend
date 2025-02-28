<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['id' => 1, 'description' => 'Super Administrador'],
            ['id' => 2, 'description' => 'Administrador'],
            ['id' => 3, 'description' => 'Empleado'],
            ['id' => 4, 'description' => 'Cliente'],
        ];

        foreach ($userTypes as $userType) {
            UserType::create($userType);
        }
    }
}
