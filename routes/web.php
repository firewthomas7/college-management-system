<?php

use App\Http\Controllers\Auth\RoleRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', RoleRedirectController::class)
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';
