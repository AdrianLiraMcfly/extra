<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $roles = [
            ['rol' => 'admin'],
            ['rol' => 'user'],
        ];

        foreach ($roles as $rol) {
            Role::create($rol);
        }
    }
}
