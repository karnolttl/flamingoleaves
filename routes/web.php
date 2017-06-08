<?php

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

Auth::routes();
Route::get('register/confirm/{token}', 'Auth\RegisterController@confirmEmail');
Route::get('blog', [ 'uses' => 'BlogController@index', 'as' => 'blog.index']);
Route::get('blog/{slug}/{reply_id?}', ['uses' => 'BlogController@single', 'as' => 'blog.single'])
    ->where('slug', '[\w\d\-\_]+');
Route::get('/',['uses' => 'PageController@home', 'as' => 'pages.home']);
Route::get('about',['uses' => 'PageController@about', 'as' => 'pages.about']);
Route::get('contact',['uses' => 'PageController@contact', 'as' => 'pages.contact']);
Route::post('contact',['uses' => 'PageController@postContact', 'as' => 'pages.postcontact']);
Route::resource('posts', 'PostController');
Route::resource('categories', 'CategoryController', ['except' => ['create']]);
Route::resource('tags', 'TagController', ['except' => ['create']]);
Route::resource('image', 'ImgController', ['only' => ['show', 'destroy']]);
Route::get('auth/google', 'Auth\LoginController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('profile', ['uses' => 'ProfileController@display', 'as' => 'profile.display']);
Route::put('profile', ['uses' => 'ProfileController@update', 'as' => 'profile.update']);
