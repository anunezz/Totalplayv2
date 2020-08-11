<?php

use App\Http\Controllers\GunControlController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Concerns\FromView;

 Route::group(['middleware' => ['auth:api']], function () {

    Route::get('guncontrol/getGunControl', 'GunControlController@getGunControl');
    Route::post('guncontrol/registerGunControl', 'GunControlController@registerGunControl');
 //   Route::get('cats/get-cat', 'CatalogsController@getCatalogByType');
    Route::get('cats/getDetailsUser', 'CatalogsController@getDetailsUser');


 });
