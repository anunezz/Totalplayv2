<?php

use App\Http\Controllers\GunControlController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Concerns\FromView;

// Rutas para el modulo de administración


Route::group(['middleware' => 'auth:api'], function () {

    Route::resource('users', 'Administrador\UsersController');
    Route::post('users/unit', 'CatalogsController@saveRegister');

});
