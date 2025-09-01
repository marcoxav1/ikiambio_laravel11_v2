<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\IkiambioUserController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

use App\Http\Controllers\Api\V1\AuthController;

// Define el limitador "api": 60 req/min por usuario autenticado o IP
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

/* Route::prefix('v1')->group(function () {
    // Diagnóstico
    Route::middleware('auth:sanctum')->get('me', fn(Request $r) => $r->user());

    // Protegidas (sin abilities por ahora)
    Route::middleware(['auth:sanctum','throttle:api'])->group(function () {
        Route::apiResource('ikiambio-users', IkiambioUserController::class);
    });
}); */

Route::prefix('v1')->group(function () {
    Route::post('auth/token', [AuthController::class, 'issueToken']);

    Route::middleware(['auth:sanctum','throttle:api'])->group(function () {
        Route::apiResource('ikiambio-users', IkiambioUserController::class);
    });
});

