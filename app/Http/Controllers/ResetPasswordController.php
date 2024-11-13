<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\{Auth, Hash, Password, Validator};

class ResetPasswordController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => ['required', RulesPassword::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);

        if ($validator->fails()) {
            return static::errorResponse([
                'message' => $validator->errors(),
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? static::successResponse(['status' => __($status)])
            : static::errorResponse(['message' => ['email' => __($status)]]);
    }

    public function verifyToken(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return static::errorResponse([
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        /** @var User $user */
        $user    = User::query()->firstWhere('email', $validated['email']);
        $isValid = app(PasswordBroker::class)->getRepository()->exists($user, $validated['token']);

        return static::successResponse([
            'message' => 'Your token has ' . ($isValid ? '' : 'not ') . 'been verified',
            'success' => $isValid,
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return self::successResponse(['message' => 'Logout successfully.']);
    }
}
