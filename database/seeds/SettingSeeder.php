<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Setting::create([
            'site_name' => 'vuejs test',
            'contact_email' => 'omranklaai@gmail.com',
            'address' => 'adress exemple'
        ]);
    }
}
