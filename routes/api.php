<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResetPasswordController;
use Laravel\Fortify\Http\Controllers\{RegisteredUserController, PasswordResetLinkController, AuthenticatedSessionController};

Route::group(['middleware' => 'auth:sanctum'], function(): void {
    Route::prefix('auth')->group(function (): void {
        Route::withoutMiddleware('auth:sanctum')->group(function (): void {
            Route::post('/login',[AuthenticatedSessionController::class, 'store']);
            Route::post('/register',[RegisteredUserController::class, 'store']);
            Route::post('/forgot-password',(new PasswordResetLinkController)->store(...));
            Route::post('/verify-token', (new ResetPasswordController)->verifyToken(...));
            Route::post('/reset-password',(new ResetPasswordController)->store(...))->name('password.reset');
        });
    });

    Route::post('logout', (new ResetPasswordController)->logout(...));
});