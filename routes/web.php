<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {print "<pre>"; print_r('sdsasas');die;
    return view('welcome');
});
