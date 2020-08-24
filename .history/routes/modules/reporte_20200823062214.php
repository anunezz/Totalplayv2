<?php

use App\Http\Controllers\ReportController;

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('report/proceedings', 'ReportController@Proceedings');
    Route::post('report/label', 'ReportController@Label');
    Route::get('report/labelBox', 'ReportController@LabelBox');
    Route::post('report/lowDocumentary', 'ReportController@Label');
});

