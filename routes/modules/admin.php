<?php

// Rutas para el modulo de administración


Route::group(['middleware' => 'auth:api'], function () {

    Route::resource('users', 'Administrador\UsersController');


});
