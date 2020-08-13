<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('formalitiesSicar', 'SICAR\FormalitiesSicarController');
});
