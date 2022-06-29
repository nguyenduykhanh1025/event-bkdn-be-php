<?php

use Illuminate\Support\Facades\Route;

Route::get('paginate', 'App\Http\Controllers\ManagerEventController@paginate');
Route::post('', 'App\Http\Controllers\ManagerEventController@create');
Route::get('{id}', 'App\Http\Controllers\ManagerEventController@show');
Route::get('', 'App\Http\Controllers\ManagerEventController@all');
