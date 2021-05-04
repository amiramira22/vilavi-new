<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class User {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard ='web') {
       if ((Auth::guard($guard)->check()) && ($request->user()->access == 'User')) {
            return $next($request);
        }
        return redirect('/');
    }

    /*
      public function handle($request, Closure $next) {
  
            return $next($request);
       
    }*/
}
