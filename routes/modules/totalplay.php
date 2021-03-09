<?php

use Illuminate\Support\Facades\Route;

    Route::post('setContact', 'TotalplayController@setContact');
    Route::post('setPacks', 'TotalplayController@setPacks');
    Route::get('getCats', 'TotalplayController@getCats');
    Route::get('createImg/{id}', 'TotalplayController@createImg');
