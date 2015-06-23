<?php

Route::get('/', [
  'as' => 'home',
  'uses' => 'PagesController@index'
]);


/**
 * Users methods
 */
Route::get('/signup', [
  'as' => 'signup',
  'uses' => 'UsersController@create',
]);
Route::get('/profile/{username}', [
  'as' => 'profile',
  'uses' => 'UsersController@show'
]);
Route::resource('/users', 'UsersController', [
  'only' => ['create', 'store', 'show']
]);


/**
 * Session methods
 */
Route::get('/login', [
  'as' => 'login',
  'uses' => 'SessionsController@create',
]);
Route::get('/logout', [
  'as' => 'logout',
  'uses' => 'SessionsController@destroy'
]);
Route::resource('/sessions', 'SessionsController', [
  'only' => ['create', 'store', 'destroy']
]);


/**
 * Protests routes
 */
Route::resource('/protests', 'ProtestsController');


/**
 * Messages routes
 */
Route::resource('/messages', 'MessagesController', [
  'except' => ['edit', 'update', 'destroy', 'show']
]);

Route::get('/messages/{username}', [
  'as' => 'messages.show',
  'uses' => 'MessagesController@show'
]);

/**
 * Updates routes
 */
Route::resource('/updates', 'UpdatesController', [
  'except' => ['index', 'show']
]);

/**
 * Comments routes
 */
Route::resource('protest.comments', 'CommentsController', [
  'except' => ['index', 'show']
]);

/**
 * Markdown route
 */
Route::post('/markdown/preview', [
  'as' => 'markdown.preview',
  'uses' => 'MarkdownController@preview'
]);
