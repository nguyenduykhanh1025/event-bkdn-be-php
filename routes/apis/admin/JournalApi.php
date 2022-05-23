<?php

use Illuminate\Support\Facades\Route;

Route::get('paginate', 'App\Http\Controllers\JournalController@paginate');
Route::post('', 'App\Http\Controllers\JournalController@create');
Route::get('{id}', 'App\Http\Controllers\JournalController@show');
Route::delete('{id}', 'App\Http\Controllers\JournalController@delete');
