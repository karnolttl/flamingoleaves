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
Route::get('/','PageController@home');
Route::get('about','PageController@about');
Route::get('contact','PageController@contact');
Route::resource('posts', 'PostController');
