<?php

use Illuminate\Support\Facades\Route;

Route::get('paginate', 'App\Http\Controllers\EventController@paginate');
Route::get('paginate-event-incoming', 'App\Http\Controllers\EventController@paginateEventIncoming');
Route::get('paginate-event-happening', 'App\Http\Controllers\EventController@paginateEventHappening');
Route::get('paginate-event-over', 'App\Http\Controllers\EventController@paginateEventOver');
Route::get('get-events-join-by-id-user', 'App\Http\Controllers\EventController@getEventsJoinByIdUser');


Route::get('{id}', 'App\Http\Controllers\EventController@show');
Route::post('', 'App\Http\Controllers\EventController@create');
Route::put('', 'App\Http\Controllers\EventController@update');
