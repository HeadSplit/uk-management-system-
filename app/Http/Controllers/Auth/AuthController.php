<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AuthRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $remember = $data['remember_me'] ?? false;

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('index');
        }

        return back()->withErrors([
            'email' => 'Неверный логин или пароль',
        ])->onlyInput('email');
    }

}
