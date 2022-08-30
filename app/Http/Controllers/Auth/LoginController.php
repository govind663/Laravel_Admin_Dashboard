<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {

      return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|string',
        ],[
           'email.required' => 'Email Id is required',
           'password.required' => 'Password is required',
          ]);

        $credentials = $request->only('email', 'password');
        $remember_me = $request->has('remember_token') ? true : false;

        if (Auth::attempt($credentials, $remember_me)) {
            return redirect()->intended('/home')->with('message', 'You are login successfully.');
        }
        else{
            return redirect()->back()->with(['Input' => $request->only('email', 'remember'), 'error' => 'Your Email and Password do not match our records!']);;
        }

    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return redirect('login')->with('message', 'You are logout successfully.');
    }
}
