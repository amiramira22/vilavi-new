<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use Session;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $username = 'username';
    protected $redirectTo = '/dashboard';
    protected $guard = 'web';

    public function getLogin()
    {

        if (Auth::guard('web')->check()) {
            return redirect()->route('postlogin');
        } else {
            return view('login')->with('message', 'Login Failed ! please check your username and password');
        }
    }

    public function postLogin(Request $request)
    {
        $auth = Auth::guard('web')->attempt(['email' => $request->username,
            'password' => $request->password, 'active' => 1]);
        $request->session()->flush();
        $request->session()->regenerate();

        if ($auth) {

            $request->session()->put('connected_user_name', Auth::user()->name);
            $request->session()->put('connected_user_email', Auth::user()->email);
            $request->session()->put('connected_user_id', Auth::user()->id);
            $request->session()->put('connected_user_acces', Auth::user()->access);
            $request->session()->put('connected_user_photo', Auth::user()->photo);
            $request->session()->put('connected_user_lang', Auth::user()->lang);


            if (Auth::user()->access == 'Responsible')
                return redirect()->route('visit.orderReport');

            else

                return redirect()->route('dashboard');
        } else
            return redirect('/')->with('message', 'Login Failed ! please check your username and password');
    }

    public function getLogout()
    {
        request()->session()->flush();
        Auth::guard('web')->logout();
        return redirect('/');
    }

}
