<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard.home',[ "route" => "home" ]);
});

Route::get('/login', function () {
    return view('dashboard.login',[ "route" => "login" ]);
});

Route::get('/register', function () {
    return view('dashboard.register',[ "route" => "register" ]);
});

Route::group([ 'prefix' => 'auth' ],function(){

    Route::post('/login','AuthController@login');
    Route::post('/register','AuthController@register');
    Route::get('/logout','AuthController@logout');

});

Route::group(['middleware' => [CheckUser::class]],function(){

// P O S T
    Route::get('/posts','PostController@show');
    Route::get('/posts/{id}','PostController@showPost');
    Route::get('/posts/edit/{id}','PostController@showUpdate');
    Route::put('/posts/{id}','PostController@update');
    Route::delete('/posts/{id}','PostController@delete');
    Route::post('/posts','PostController@create');

// // My BLOG
    Route::get('/accaunt/blogs','PostController@showMyBlogs');
// // Accaunt Settings
    Route::get('/accaunt/settings','AuthController@showAccaunt');
    Route::put('/accaunt/settings','AuthController@update');

// Like
    Route::get('/post/onlike/{postId}/{status}','PostController@onliked');

// C O M M E N T
    Route::group([ 'prefix' => 'comment' ],function(){
        Route::post('/{postId}','CommentController@create');
        Route::put('/update','CommentController@update');
        Route::delete('/{commentId}','CommentController@delete');
    });

});