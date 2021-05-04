<?php
namespace App\Http\Controllers\Promoter;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;

class GeoController extends Controller {

protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    function index(Request $request) {

        $save['id'] = Auth::user()->id;
        $save['latitude'] = $request->lat ;
        $save['longitude'] = $request->lng ;
       
        $this->userRepository->update($save['id'], $save);
   
    }

}
