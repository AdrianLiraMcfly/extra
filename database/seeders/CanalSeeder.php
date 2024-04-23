<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Canal;

class CanalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $canales = [
            [
                'nombre'  => "Xbox",
                'user_id' =>  1,
                'is_active' => true
            ],
            [
                'nombre'  => "PlayStation",
                'user_id' =>  2,
                'is_active' => true
            ],
        ];

        foreach ($canales as $c) {
            Canal::create($c);
        }
    }
}
