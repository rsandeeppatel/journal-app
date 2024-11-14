<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{TagController, UserController, CategoryController, JournalController, ResetPasswordController, SettingController};
use Laravel\Fortify\Http\Controllers\{RegisteredUserController, PasswordResetLinkController, AuthenticatedSessionController};

Route::group(['middleware' => ['auth:sanctum', 'parse.response']], function(): void {
    Route::prefix('auth')->group(function (): void {
        Route::withoutMiddleware('auth:sanctum')->group(function (): void {
            Route::post('/login',[AuthenticatedSessionController::class, 'store']);
            Route::post('/register',[RegisteredUserController::class, 'store']);
            Route::post('/forgot-password',(new PasswordResetLinkController)->store(...));
            Route::post('/verify-token', (new ResetPasswordController)->verifyToken(...));
            Route::post('/reset-password',(new ResetPasswordController)->store(...))->name('password.reset');
        });
    });

    Route::prefix('user')->group(function (): void {
        Route::get('/', (new UserController)->show(...));
    });

    // Route::apiResource('setting', SettingController::class)->only(['show', 'update']);
    Route::apiResource('journals', JournalController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::post('logout', (new ResetPasswordController)->logout(...));
});