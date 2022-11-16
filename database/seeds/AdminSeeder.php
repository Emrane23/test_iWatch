<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
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
            'email' => 'omran@gmail.com',
            'password' => Hash::make('123456'),
            'profile_image' => 'img1.jpg',
            'is_admin' => true
        ]);
    }
}
