<?php

use App\Http\Controllers\ReportController;

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('report/proceedings', 'ReportController@Proceedings');
});
