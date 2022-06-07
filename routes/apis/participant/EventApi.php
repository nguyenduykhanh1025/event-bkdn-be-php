<?php

use Illuminate\Support\Facades\Route;

Route::get('get-events-participating', 'App\Http\Controllers\EventController@getEventsParticipating');
Route::get('get-events-joined', 'App\Http\Controllers\EventController@getEventsJoined');
Route::get('get-events-in-progress-accept', 'App\Http\Controllers\EventController@getEventsInProgressAccept');
Route::get('paginate-event-incoming', 'App\Http\Controllers\EventController@paginateEventIncoming');
Route::get('{id}', 'App\Http\Controllers\EventController@show');