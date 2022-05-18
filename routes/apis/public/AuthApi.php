<?php

use Illuminate\Support\Facades\Route;

Route::post('/register-admin-account', 'App\Http\Controllers\AuthController@registerAdminAccount');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/register-new-participant', 'App\Http\Controllers\AuthController@registerNewParticipant');
