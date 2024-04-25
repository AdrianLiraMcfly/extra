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
            'name'  => "Adrian",
            'email' => "jorge.liralopez11@gmail.com",
            'role_id'    =>  1,
            'is_active'    => true,
            'password'  => Hash::make('12345678')]
        ];

        foreach ($user as $u) {
            User::create($u);
        }
    }
}
