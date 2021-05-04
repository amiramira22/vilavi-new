<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class LoginController extends Controller {

    use AuthenticatesUsers;

    protected $username = 'username';
    protected $redirectTo = '/dashboard';
    protected $guard = 'web';

    public function getLogin() {

        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        } else {
            return view('login')->with('message', 'Login Failed ! please check your username and password');
        }
    }

    public function postLogin(Request $request) {
        $auth = Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password, 'active' => 1]);
        if ($auth && Auth::user()->access == 'Admin') {
            \request()->session()->put('connected_user_name', Auth::user()->name);
            \request()->session()->put('connected_user_email', Auth::user()->email);
            \request()->session()->put('connected_user_id', Auth::user()->id);
            \request()->session()->put('connected_user_photo', Auth::user()->photo);
            \request()->session()->put('connected_user_acces', Auth::user()->access);

            return redirect()->route('dashboard');
        }
        return redirect('/')->with('message', 'Login Failed ! please check your username and password');
    }

    public function getLogout() {
        Auth::guard('web')->logout();
        return redirect('/');
    }

}
