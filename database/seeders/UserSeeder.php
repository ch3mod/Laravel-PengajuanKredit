<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Dhea Nurfauziah',
            'email' => 'naruto@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Dhea Nurfauziah',
            'email' => 'sasuke@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Dhea Nurfauziah',
            'email' => 'sakura@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
