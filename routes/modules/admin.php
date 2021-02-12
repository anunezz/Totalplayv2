<?php
use Illuminate\Support\Facades\Route;
// Rutas para el modulo de administración

Route::group(['middleware' => 'auth:api'], function () {

    Route::resource('users', 'UsersController');
    Route::post('users/unit', 'CatalogsController@saveRegister');

});
