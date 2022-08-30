<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function getPassword($token) {

        return view('auth.passwords.reset', ['token' => $token]);
     }

     public function updatePassword(Request $request)
     {
         $request->validate([
           'email' => 'required|string|email|max:255|exists:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
           'password' => 'required|string|min:8|confirmed',
           'password_confirmation' => 'required',
           ],[
            'email.required' => 'Email Id is required',
            'password.required' => 'Password is required',
            'password_confirmation' => 'Confirm Password is required',
         ]);

         $updatePassword = DB::table('password_resets')
                             ->where(['email' => $request->email, 'token' => $request->token])
                             ->first();

         if(!$updatePassword)
             return back()->withInput()->with('error', 'Invalid token!');

           $user = User::where('email', $request->email)
                       ->update(['password' => Hash::make($request->password)]);

           DB::table('password_resets')->where(['email'=> $request->email])->delete();

           return redirect('/login')->with('message', 'Your password has been changed!');

     }
}
