<?php

//dd(resolve('App\Billing\Stripe'));

// Route::GET('/', 'TasksController@index');

// Route::GET('/tasks', 'TasksController@index');

// Route::GET('/tasks/{task}','TasksController@show');

//url shortener

Route::GET('/shortener', 'LinkController@index');

Route::POST('/store', 'LinkController@store');

//Blog

Route::GET('/', 'PostController@index')->name('home');

Route::GET('/posts/{post}', 'PostController@show');

Route::GET('/post/create', 'PostController@create');

Route::POST('/posts', 'PostController@store');


Route::POST('/posts/{post}/comments', 'CommentsController@store');


Route::GET('/register', 'RegistrationController@create');

Route::POST('/register', 'RegistrationController@store');


Route::GET('/login', 'SessionsController@create');

Route::POST('/login', 'SessionsController@store');

Route::GET('/logout', 'SessionsController@destroy');

Route::get('/posts/tags/{tag}', 'TagsController@index');