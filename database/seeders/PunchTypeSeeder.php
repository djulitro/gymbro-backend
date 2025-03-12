<?php

namespace Database\Seeders;

use App\Models\PunchType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PunchTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $punchTypes = [
            ['name' => 'Entrada'],
            ['name' => 'Salida'],
        ];

        foreach ($punchTypes as $punchType) {
            PunchType::create($punchType);
        }
    }
}
