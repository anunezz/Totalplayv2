<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('formalities', 'FormalitiesController');
});
