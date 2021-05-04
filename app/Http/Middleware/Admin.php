<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Admin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard ='web') {
       if ((Auth::guard($guard)->check()) && ($request->user()->access == 'Admin')) {
            return $next($request);
        }
        return redirect('/');
        
         
    }

}
