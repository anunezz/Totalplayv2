<?php

use App\Http\Controllers\ReportController;

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('report/proceedings', 'ReportController@Proceedings');
    Route::post('report/label', 'ReportController@Label');
    Route::post('report/labelBox', 'ReportController@LabelBox');
    Route::post('report/lowDocumentary', 'ReportController@lowDocumentary');
    Route::post('report/lowAccounting', 'ReportController@lowAccounting');

    //Filros
    Route::post('report/fileFilter', 'ReportController@fileFilter');


});

