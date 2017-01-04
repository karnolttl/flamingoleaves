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
Route::get('/','PageController@home');
Route::get('about','PageController@about');
Route::get('contact','PageController@contact');
Route::resource('posts', 'PostController');

// Route::get('/home', 'HomeController@index');
// Route::get('/page/{number}','PageController@list');
// Route::get('/post/{post}','PostController@show');
// Route::post('/post/{post}/comments', 'PostController@store');
//
// Route::get('love', 'myController@sendLove');
// Route::get('cards', 'CardsController@index');
// Route::get('cards/{card}', 'CardsController@show');
// Route::post('cards/{card}/notes', 'NotesController@store');
// Route::get('/notes/{note}/edit', 'NotesController@edit');
