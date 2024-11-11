<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::group(['middleware' => 'auth:sanctum'], function(): void {
    Route::prefix('auth')->group(function (): void {
        Route::withoutMiddleware('auth:sanctum')->group(function (): void {
            Route::post('/login',[AuthenticatedSessionController::class, 'store']);
            Route::post('/forgot-password',(new PasswordResetLinkController)->store(...));
            // Route::post('/verify-token', (new ResetPasswordController)->verifyToken(...));
        });
    });
});