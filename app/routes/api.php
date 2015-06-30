<?php

Route::resource('/protests', 'ProtestsController', [
    'only' => ['index', 'show']
]);

Route::get('/geocode', [
    'uses' => 'LocationController@geocode',
    'as' => 'api.geocode'
]);
