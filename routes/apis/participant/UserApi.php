<?php

use Illuminate\Support\Facades\Route;

Route::put('update-exponent-push-token', 'App\Http\Controllers\UserController@updateExponentPushToken');
Route::get('get-profile', 'App\Http\Controllers\UserController@getUserProfileByToken');
