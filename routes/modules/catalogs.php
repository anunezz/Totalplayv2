<?php

use App\Http\Controllers\GunControlController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Concerns\FromView;

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('cats/get-cat', 'CatalogsController@getCatalogByType');
    Route::put('cats/update/register', 'CatalogsController@updateRegister');
    Route::get('cats/create', 'CatalogsController@create');
    Route::post('cats/new-register', 'CatalogsController@newRegister');
    Route::get('cats/allunits', 'CatalogsController@allunits');
});

