<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::create([
            'name' => 'html tutorials',
            'slug' => 'html-tutorials',
        ]);
        \App\Category::create([
            'name' => 'css tutorials',
            'slug' => 'css-tutorials',
        ]);
        \App\Category::create([
            'name' => 'javascript tutorials',
            'slug' => 'javascript-tutorials',
        ]);
        \App\Category::create([
            'name' => 'laravel tutorials',
            'slug' => 'laravel-tutorials',
        ]);
        \App\Category::create([
            'name' => 'vuejs tutorials',
            'slug' => 'vuejs-tutorials',
        ]);
    }
}
