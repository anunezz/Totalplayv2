<?php

Route::group(['middleware' => ['auth:api']], function () {
    // Route::resource('formalitiesSicar', 'SICAR\FormalitiesSicarController');
    // Route::get('all/user/unit/sicar', 'SICAR\FormalitiesSicarController@allUserUnitSicar');
    // Route::get('download/excel/sicar', 'SICAR\FormalitiesSicarController@downloadExcel');
});
