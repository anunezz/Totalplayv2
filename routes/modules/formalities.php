<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('formalities', 'FormalitiesController');
    Route::get('all/section', 'FormalitiesController@allSection');
    Route::get('all/series', 'FormalitiesController@allSeries');
    Route::get('all/subSeries', 'FormalitiesController@allSubSeries');
    Route::post('sort-code', 'FormalitiesController@SortCode');
});