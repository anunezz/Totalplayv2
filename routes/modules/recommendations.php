<?php

use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\GunControlController;
use App\Http\Models\Recommendation;
use Maatwebsite\Excel\Concerns\FromView;


Route::group(['middleware' => ['auth:api']], function () {

    Route::resource('recommendations', 'RecommendationsController');

});



