<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLoginForm()
    {
        return view('auth.login');
    }

    public function userLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $response = [
                'redirect_url' => route('admin.dashboard'),
                'message' => "Game On! You're logged in...",
            ];
            return $request->ajax()
            ? response()->json($response, 200)
            : redirect()->intended($response['redirect_url'])->with('success', $response['message']);
        }

        return $request->ajax()
        ? response()->json(['message' => 'Invalid Credentials.'], 422)
        : redirect()->back()->with('error', 'Invalid Credentials.');
    }

}
