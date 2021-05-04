<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DashboardRepository;
use Auth;
use Session;

class DashboardController extends Controller {

    public function __construct(DashboardRepository $dashboardRepository) {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function index() {
        $user = Auth::user();
        $title = 'Dashboard';
        $subTitle = 'Dashboard';
        $current_user_id = Auth::user()->id;
        $surveys = $this->dashboardRepository->getSurveys($current_user_id);
      

        return view('user.dashboard.index', compact('title', 'surveys', 'subTitle'));
    }

    public function checkPosition($type) {
        $user = Auth::user();
        //dd($attendances);
        $save['type'] = $type;
        $save['admin_id'] = $user->id;
        $save['longitude'] = $user->longitude;
        $save['latitude'] = $user->latitude;

        $save['outlet_id'] = $user->outlet_id;
        $save['date'] = date('Y-m-d');
        $save['time'] = date('H:i:s');


        request()->session()->flash('message ', ' successfully.');
        $this->attendanceRepository->store($save);
        request()->session()->flash('message ', ' successfully.');

        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('promoter.dashboard');
    }

}
