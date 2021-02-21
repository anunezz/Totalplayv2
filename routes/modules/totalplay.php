<?php

use Illuminate\Support\Facades\Route;

    Route::post('setContact', 'TotalplayController@setContact');
    Route::post('setPacks', 'TotalplayController@setPacks');
    Route::get('getCats', 'TotalplayController@getCats');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('getUsers', 'TotalplayController@getUsers');
        Route::get('getCatsUser', 'TotalplayController@getCatsUser');
        Route::post('createUser', 'TotalplayController@createUser');
        Route::post('updateUser', 'TotalplayController@updateUser');
        Route::post('activeUser', 'TotalplayController@activeUser');
        Route::post('updatePassword', 'TotalplayController@updatePassword');
        Route::get('getContacts', 'TotalplayController@getContacts');
        Route::post('exportContacts', 'TotalplayController@exportContacts');
    });
