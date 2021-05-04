<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use App;
use App\Repositories\UserRepository;

class LanguageController {

    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function changeLang(Request $request) {
        $lan = $request->lang;


        \request()->session()->put('connected_user_lang', $request->lang);
        $save = array();
        $save['lang'] = $request->lang;

        $this->userRepository->update(Auth::user()->id, $save);
        return 1;
    }

     
    
    
}
