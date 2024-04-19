<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email'=> 'admin@gmail.com',
            'password'=> 'admin',
            'role'=> 'admin'
        ]);

    }
}
