<?php

use Illuminate\Support\Facades\Route;

Route::post('/join-to-event', 'App\Http\Controllers\EventUserController@joinToEvent');
