<?php

namespace App\Http\Controllers;

use Lang;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;
use App;
use Auth;
use App\Repositories\UserRepository;


class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $user;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            App::setlocale(request()->session()->get('connected_user_lang'));
            return $next($request);
        });
    }

}
