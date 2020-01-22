<?php

Auth::routes();


// Follow
Route::post('follow/{user}', 'FollowsController@store');

// Route::get('/home', 'HomeController@index')->name('home');
// routes for profile
Route::get('/profile', 'ProfileController@users');
Route::get('/profile/{user}', 'ProfileController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfileController@update')->name('profile.update');

// routes for diary
Route::get('/', 'DiaryController@index');
Route::get('/diary/create', 'DiaryController@create');
Route::post('/diary', 'DiaryController@store');
Route::get('/diary/{diary}', 'DiaryController@show');

// routes for task
Route::get('/diary/{diary}/task/create', 'TaskController@create');
Route::post('/diary/{diary}/task', 'TaskController@store');
Route::get('/diary/{diary}/task/{task}/edit', 'TaskController@edit');
Route::patch('/diary/{diary}/task/{task}', 'TaskController@update');

// routes for create
Route::get('/rate/{task}/create', 'RatingController@create');
Route::post('/rate/{task}', 'RatingController@store');
