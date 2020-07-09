<?php


Route::group(['middleware' => ['auth:api']], function () {
    Route::post('guncontrol/registerGunControl', 'GunControlController@registerGunControl');
});

