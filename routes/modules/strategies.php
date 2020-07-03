<?php

use App\Http\Controllers\StrategiesController;
use App\Http\Models\Recommendation;
use Maatwebsite\Excel\Concerns\FromView;

Route::group(['middleware' => ['auth:api']], function () {

    Route::resource('strategies', 'StrategiesController');

});

