<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\{Str, ServiceProvider};
use Laravel\Fortify\Contracts\{LoginResponse, RegisterResponse};
use App\Actions\Fortify\{CreateNewUser, ResetUserPassword, UpdateUserPassword, UpdateUserProfileInformation};

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request)
            {
                if ($request->wantsJson()) {
                    $user = User::query()->where('email', $request->email)->first();

                    return response()->json([
                        'message' => 'You are successfully logged in',
                        'token'   => $user->createToken($request->email)->plainTextToken,
                    ], 200);
                }

                return redirect()->intended(Fortify::redirects('login'));
            }
        });

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse
        {
            public function toResponse($request)
            {
                $user = User::query()->where('email', $request->email)->first();

                return $request->wantsJson()
                    ? response()->json([
                        'message' => 'Registration successful, verify your email address',
                        'token'   => $user->createToken($request->email)->plainTextToken,
                    ], 200)
                    : redirect()->intended(Fortify::redirects('register'));
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
