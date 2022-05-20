<?php

use Illuminate\Support\Facades\Route;

Route::get('paginate', 'App\Http\Controllers\EventController@paginate');
Route::get('show/{id}', 'App\Http\Controllers\EventController@show');