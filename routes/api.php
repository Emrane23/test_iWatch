<?php

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('posts','PostController');
Route::apiResource('categories','CategoryController');
Route::get('category/{slug}/posts','PostController@categoryPosts');
Route::get('searchposts/{query}','PostController@search');
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::get('user/categories', 'UserController@getCategories');


Route::middleware('auth:api')->group(function () {
    Route::get('user', 'UserController@details');
    Route::post('comment/create', 'CommentController@store');
    Route::delete('posts/delete/{id}', 'PostController@deletePost');
    
    Route::get('get-unread-notifications', 'UserController@getUnreadNotifications');
    Route::get('get-all-notifications', 'UserController@getAllNotifications');
    Route::put('mark-notifications-as-read', 'UserController@markNotificationsAsRead');
    Route::post('user/addpost', 'UserController@addPost');
    // Route::resource('products', 'ProductController');
});
Route::group(['prefix' => '/admin' ,'middleware'=>'auth:api'],function(){
    Route::get('posts', 'AdminController@index');
    Route::get('categories', 'AdminController@getCategories');
    
    Route::post('addpost', 'AdminController@addPost');
    
    Route::post('updatepost', 'AdminController@UpdatePost');
    
});