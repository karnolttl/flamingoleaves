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
Route::get('blog', [ 'uses' => 'BlogController@index', 'as' => 'blog.index']);
Route::get('blog/{slug}', ['uses' => 'BlogController@single', 'as' => 'blog.single'])
    ->where('slug', '[\w\d\-\_]+');
Route::get('/',['uses' => 'PageController@home', 'as' => 'pages.home']);
Route::get('about',['uses' => 'PageController@about', 'as' => 'pages.about']);
Route::get('contact',['uses' => 'PageController@contact', 'as' => 'pages.contact']);
Route::resource('posts', 'PostController');
Route::resource('categories', 'CategoryController', ['except' => ['create']]);
Route::resource('tags', 'TagController', ['except' => ['create']]);
