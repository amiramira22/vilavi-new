<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\DashboardRepository;

class DashboardController extends Controller {

      protected $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository) {
        $this->dashboardRepository = $dashboardRepository;
      
    }

    public function index() {
        $title = 'Dashboard';
        $subTitle = 'Dashboard & Statistics';
        
        $totalSurveys= $this->dashboardRepository->getTotalVisits();
        $totalVisits= $this->dashboardRepository->getTotalActiveSurveys();
        $totalDailyVisits= $this->dashboardRepository->getDailyVisits();

        
        return view('client.dashboard.index', compact('title', 'subTitle','totalSurveys','totalVisits','totalDailyVisits'));
    }

}
