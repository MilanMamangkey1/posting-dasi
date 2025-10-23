<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This file is reserved for future public API endpoints. Admin JSON endpoints
| now live under `routes/web.php` with session-based authentication.
|
*/

Route::get('/status', fn () => response()->json(['status' => 'ok']));
