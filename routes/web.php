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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// routes for profile
Route::get('/profile/{user}', 'ProfileController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfileController@update')->name('profile.update');

// routes for diary
Route::get('/diary/create', 'DiaryController@create');
Route::post('/diary', 'DiaryController@store');
Route::get('/diary/{diary}', 'DiaryController@show');

// routes for task
Route::get('/diary/task/create', 'TaskController@create');
Route::post('/diary/task', 'TaskController@store');
