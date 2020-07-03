<?php

Route::any('{path?}', function() {
    return view("app");
})->where("path", ".+");
