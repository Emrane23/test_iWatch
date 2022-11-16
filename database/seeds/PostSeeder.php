<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Post::create([
            'title' => 'a simple title',
            'slug' => Str::slug('a simple slug'),
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.
             Distinctio impedit laudantium ea delectus facere officiis vitae quasi mollitia laborum! Corrupti ad error id recusandae aut quidem iusto possimus. Accusamus, quibusdam!',
             'image' => 'p1.jpg',
             'user_id' => 1 ,
             'category_id' => 1
        ]);
        \App\Post::create([
            'title' => 'a simple title',
            'slug' => Str::slug('a simple slug'),
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.
             Distinctio impedit laudantium ea delectus facere officiis vitae quasi mollitia laborum! Corrupti ad error id recusandae aut quidem iusto possimus. Accusamus, quibusdam!',
             'image' => 'p2.jpg',
             'user_id' => 1 ,
             'category_id' => 2
        ]);
        \App\Post::create([
            'title' => 'laravel intro ',
            'slug' => Str::slug('laravel intro '),
            'body' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.
             Distinctio impedit laudantium ea delectus facere officiis vitae quasi mollitia laborum! Corrupti ad error id recusandae aut quidem iusto possimus. Accusamus, quibusdam!',
             'image' => 'p3.jpg',
             'user_id' => 1 ,
             'category_id' => 3
        ]);
    }
}
