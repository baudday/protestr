<?php

Route::resource('/protests', 'ProtestsController', [
    'only' => ['index', 'show']
]);
