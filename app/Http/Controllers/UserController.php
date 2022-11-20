<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'profile_image' =>'imagetest.jpg',
            'password' => bcrypt($request->password),
            'is_admin' => false
        ]);
 
        $token = $user->createToken('TutsForWeb')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('pg')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    public function getCategories()
    {
       $categories = Category::get();
       return response()->json($categories);
    }

    public function addPost(Request $request )
    {
        $filename='';
        if($request->hasFile('image')){
            $filename = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('img'),$filename);
        }
        $post = Post::create([
            'title' => $request->title , 
            'body' => $request->body ,
            'slug' =>Str::slug($request->title),
            'category_id' => $request->category, 
            'user_id' => Auth::id(),
            'image' => $filename , 

        ]);
        return response()->json($post);
    }
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    public function getUnreadNotifications()
    {
       $notifications = Auth::user()->unreadNotifications  ;
       return response()->json($notifications);
    }

    public function getAllNotifications()
    {
       $notifications = Auth::user()->notifications ;
       return response()->json($notifications);
    }
}
