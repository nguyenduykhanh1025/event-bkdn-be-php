<?php

use Illuminate\Support\Facades\Route;

// * start PUBLIC ROUTE ==========================>
Route::name('auth')->prefix('auth')->group(base_path('routes/apis/public/AuthApi.php'));

// * start AUTH ROUTE ==========================>
Route::group(['middleware' => ['verify.authenticate.token', 'verify.authorization.token']], function () {
    /**
     * start API FOR ADMIN
     */
    Route::name('admin-user')->prefix('admin/users')->group(base_path('routes/apis/admin/UserApi.php'));

    /**
     * start API FOR PARTICIPANT
     */
});
