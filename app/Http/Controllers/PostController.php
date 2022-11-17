<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->with('user')->paginate(1);
        foreach ($posts as $key => $post) {
            $post->setAttribute('added_at',$post->created_at->diffForHumans());
            $post->setAttribute('comments_count',$post->comments->count());
        }
        return response()->json($posts);
    }

    public function deletePost($id)
    {
       $post = Post::where('id',$id)->with('user')->first();
       
       if ($post->user->id != Auth::id()) {
        return response()->json(['message' => 'you are not allowed!']);
       }
       else{
        $post->delete();
       }

        return response()->json(['message' => 'deleted']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            'id' => $post->id,
            'slug' => $post->slug,
            'body' => $post->body, 
            'added_at_date' => date("d F Y",strtotime($post->created_at )) ,
            'added_at_hour' => date("H:i",strtotime($post->created_at )) ,
            'comments_count' => $post->comments->count(),
            'image' => $post->image, 
            'user' => $post->user,
            'title' => $post->title, 
            'category' => $post->category,
            'comments' => $this->commentsFormatted($post->comments)
        ]);
    }

    public function commentsFormatted($comments)
    {
        $new_comments = []; 
        foreach ($comments as $key => $comment) {
            array_push($new_comments,[
                'id' => $comment->id,
                'body' =>$comment->body,
                'user' =>$comment->user ,
                'added_at' => $comment->created_at->diffForHumans(),
            ]);
        }
        return $new_comments ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function categoryPosts($slug)
    {
        $category = Category::whereSlug($slug)->first();
        $posts = Post::whereCategoryId($category->id)->with('user')->get();
        foreach ($posts as $key => $post) {
            $post->setAttribute('added_at',$post->created_at->diffForHumans());
            $post->setAttribute('comments_count',$post->comments->count());
        }
        return response()->json($posts);
    }

    public function search($query)
    {
        $posts = Post::where('title','like','%'.$query.'%')->with('user');
        $nbrPosts = count($posts->get());
        foreach ($posts->get() as $key => $post) {
            $post->setAttribute('added_at',$post->created_at->diffForHumans());
            $post->setAttribute('comments_count',$post->comments->count());
        }
        $posts = $posts->paginate(intval($nbrPosts));
        return response()->json($posts);
    }
}
