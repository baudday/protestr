<?php

Route::resource('/', 'SplashController', [
  'only' => ['index', 'store']
]);

Route::get('/thanks', [
  'as' => 'thanks',
  'uses' => 'SplashController@thanks'
]);

// /**
//  * Users methods
//  */
// Route::get('/signup', [
//   'as' => 'signup',
//   'uses' => 'UsersController@create',
// ]);
// Route::get('/profile/{username}', [
//   'as' => 'profile',
//   'uses' => 'UsersController@show'
// ]);
// Route::resource('/users', 'UsersController', [
//   'only' => ['create', 'store', 'show']
// ]);


// /**
//  * Session methods
//  */
// Route::get('/login', [
//   'as' => 'login',
//   'uses' => 'SessionsController@create',
// ]);
// Route::get('/logout', [
//   'as' => 'logout',
//   'uses' => 'SessionsController@destroy'
// ]);
// Route::resource('/sessions', 'SessionsController', [
//   'only' => ['create', 'store', 'destroy']
// ]);

// /**
//  * Protests routes
//  */
// Route::resource('/protests', 'ProtestsController');
