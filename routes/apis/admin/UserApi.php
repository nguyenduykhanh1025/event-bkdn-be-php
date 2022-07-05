<?php

use Illuminate\Support\Facades\Route;

Route::get('paginate', 'App\Http\Controllers\UserController@paginate');
Route::get('paginate-participant', 'App\Http\Controllers\UserController@paginateParticipant');
Route::get('paginate', 'App\Http\Controllers\UserController@paginate');
Route::get('get-users-by-id-event-and-status', 'App\Http\Controllers\UserController@getUsersByIdEventAndStatus');
Route::get('get-users-by-id-event', 'App\Http\Controllers\UserController@getUsersByIdEvent');
Route::get('get-user-by-id', 'App\Http\Controllers\UserController@getUserById');

Route::put('disable', 'App\Http\Controllers\UserController@disableUser');
Route::put('enable', 'App\Http\Controllers\UserController@enableUser');
Route::put('update-password', 'App\Http\Controllers\UserController@updatePassword');
Route::put('update-avatar', 'App\Http\Controllers\UserController@updateAvatar');
Route::put('{id}', 'App\Http\Controllers\UserController@updateUserById');
