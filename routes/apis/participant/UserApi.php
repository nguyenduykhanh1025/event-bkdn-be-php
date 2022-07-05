<?php

use Illuminate\Support\Facades\Route;

Route::put('update-exponent-push-token', 'App\Http\Controllers\UserController@updateExponentPushToken');
Route::get('get-profile', 'App\Http\Controllers\UserController@getUserProfileByToken');
Route::put('update-profile', 'App\Http\Controllers\UserController@updateProfileInformationForParticipant');
Route::put('update-password', 'App\Http\Controllers\UserController@updatePasswordForParticipant');

