<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administrador\catalogs\CatalogsController;

Route::group(['middleware' => ['auth:api']], function () {
 //   Route::get('cats/get-cat', 'CatalogsController@getCatalogByType');
});

