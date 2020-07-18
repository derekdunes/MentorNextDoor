<?php

//dd(resolve('App\Billing\Stripe'));

// Route::GET('/', 'TasksController@index');

// Route::GET('/tasks', 'TasksController@index');

// Route::GET('/tasks/{task}','TasksController@show');

//url shortener

Route::GET('/shortener', 'LinkController@index');

Route::POST('/store', 'LinkController@store');

//Blog

Route::resource('posts', 'PostController');

Route::GET('/', 'PostController@index')->name('home');

// Route::GET('/posts/{post}', 'PostController@show');

// Route::GET('/posts/{post}/edit', 'PostController@edit');

// Route::GET('/posts/create', 'PostController@create');

// Route::POST('/posts', 'PostController@store');

// Route::POST('/postUpdate/{post}', 'PostController@update');


Route::POST('/posts/{post}/comments', 'CommentsController@store');

Route::GET('/register', 'RegistrationController@create');

Route::POST('/register', 'RegistrationController@store');

Route::get('/posts/tags/{tag}', 'TagsController@index');

Route::GET('/login', 'SessionsController@create');

Route::POST('/login', 'SessionsController@store');

// Auth::routes();

Route::GET('/logout', 'SessionsController@destroy');

