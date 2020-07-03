<?php
//Rutas Generales
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');

Route::group(['middleware' => ['auth:api']], function () {

    // Obtiene la información de un usuario
    Route::get('user/{id}', 'LoginController@user');

    // Agrega la trazabilidad de un usuario
    Route::post('transaction', 'TransactionsController@store');
    Route::get('count-registers', 'GeneralController@getCountRegisters');
});

