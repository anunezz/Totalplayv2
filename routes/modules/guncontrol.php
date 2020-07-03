<?php

use App\Http\Controllers\GunControlController;
use Maatwebsite\Excel\Concerns\FromView;

 Route::group(['middleware' => ['auth:api']], function () {

    Route::get('guncontrol/getGunControl', 'GunControlController@getGunControl');
    Route::post('guncontrol/registerGunControl', 'GunControlController@registerGunControl');

 });
