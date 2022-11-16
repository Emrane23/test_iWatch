<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Emrane Klaai',
            'email' => 'omranklaai@gmail.com',
            'password' => Hash::make('123456'),
            'profile_image' => 'img1.jpg'
        ]);
    }
}
