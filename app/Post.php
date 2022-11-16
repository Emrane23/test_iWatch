<?php

namespace App;
use App\Category ;
use App\User ;
use App\Comment ;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $guarded = [''];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public function comments()
    {
       return $this->hasMany(Comment::class);
    }
}
