<?php

use Illuminate\Support\Facades\Route;

Route::put('accepted-user-join-to-event', 'App\Http\Controllers\EventUserController@acceptedUserJoinToEvent');
Route::put('rejected-user-join-to-event', 'App\Http\Controllers\EventUserController@rejectToEvent');