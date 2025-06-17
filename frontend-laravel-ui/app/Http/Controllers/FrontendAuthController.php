<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontendAuthController extends Controller
{
    public function showLogin()
    {
        // Generate math captcha
        $a = rand(1, 10);
        $b = rand(1, 10);
        session(['captcha_result' => $a + $b]);
        session(['captcha_question' => "$a + $b = ?"]);

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha_input' => 'required|numeric'
        ]);

        if ($request->captcha_input != session('captcha_result')) {
            return back()->with('error', 'Captcha is incorrect');
        }

        // Call backend API
        $response = Http::post('http://127.0.0.1:8000/api/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($response->successful()) {
            session(['api_token' => $response['token'], 'user' => $response['user']]);

            return redirect('/dashboard');
        }


        return back()->with('error', 'Invalid credentials');
    }

public function showRegister()
{
    $a = rand(1, 10);
    $b = rand(1, 10);
    session(['captcha_result' => $a + $b]);
    session(['captcha_question' => "$a + $b = ?"]);

    return view('register');
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
        'captcha_input' => 'required|numeric'
    ]);

    if ($request->captcha_input != session('captcha_result')) {
        return back()->with('error', 'Captcha is incorrect');
    }

    $response = Http::post('http://127.0.0.1:8000/api/register', [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
        'password_confirmation' => $request->password_confirmation,
        'captcha_answer' => $request->captcha_input,
       // 'role' => 'user'

    ]);

    if ($response->successful()) {
        session(['api_token' => $response['token'], 'user' => $response['user']]);
        return redirect('/dashboard');
    }

    return back()->with('error', 'Registration failed');
}
public function logout(Request $request)
{
    session()->forget(['api_token', 'user']);
    session()->flush();

    return redirect('/login')->with('success', 'Logged out successfully');
}


}
