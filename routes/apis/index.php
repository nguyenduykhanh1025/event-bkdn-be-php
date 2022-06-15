<?php

use Illuminate\Support\Facades\Route;

// * start PUBLIC ROUTE ==========================>
Route::name('auth')->prefix('auth')->group(base_path('routes/apis/public/AuthApi.php'));
Route::name('event-user')->prefix('event-users')->group(base_path('routes/apis/public/EventUserApi.php'));

// * start AUTH ROUTE ==========================>
Route::group(['middleware' => ['verify.authenticate.token', 'verify.authorization.token']], function () {
    /**
     * start API FOR ADMIN
     */
    Route::name('admin-user')->prefix('admin/users')->group(base_path('routes/apis/admin/UserApi.php'));
    Route::name('admin-event')->prefix('admin/events')->group(base_path('routes/apis/admin/EventApi.php'));
    Route::name('admin-journal')->prefix('admin/journals')->group(base_path('routes/apis/admin/JournalApi.php'));
    Route::name('admin-event-user')->prefix('admin/event-users')->group(base_path('routes/apis/admin/EventUserApi.php'));

    /**
     * start API FOR PARTICIPANT
     */
    Route::name('participant-event')->prefix('participant/events')->group(base_path('routes/apis/participant/EventApi.php'));
    Route::name('participant-event-user')->prefix('participant/event-users')->group(base_path('routes/apis/participant/EventUserApi.php'));
    Route::name('participant-journal')->prefix('participant/journals')->group(base_path('routes/apis/participant/JournalApi.php'));
});
