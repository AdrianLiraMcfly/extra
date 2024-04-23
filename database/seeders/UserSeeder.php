<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
            'name'  => "Vielma",
            'email' => "vielma7220@gmail.com",
            'rol_id'    =>  1,
            'status'    => true,
            'password'  => Hash::make('12345678')
        ],
        [
            'name'  => "Adrian",
            'email' => "jorge.liralopez11@gmail.com",
            'rol_id'    =>  1,
            'status'    => true,
            'password'  => Hash::make('12345678')]
        ];

        foreach ($user as $u) {
            User::create($u);
        }
    }
}
