<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);
    }

    public function verifyToken(Request $request) {}
}
