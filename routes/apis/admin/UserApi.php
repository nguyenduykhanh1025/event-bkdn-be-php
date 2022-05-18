<?php

use Illuminate\Support\Facades\Route;

Route::get('paginate', 'App\Http\Controllers\UserController@paginate');
Route::put('disable', 'App\Http\Controllers\UserController@disableUser');
Route::put('enable', 'App\Http\Controllers\UserController@enableUser');
Route::get('{id}', 'App\Http\Controllers\UserController@getUserById');
Route::put('{id}', 'App\Http\Controllers\UserController@updateUserById');