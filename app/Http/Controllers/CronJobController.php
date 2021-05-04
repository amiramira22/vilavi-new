<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Entities\Channel;
use App\Entities\Zone;
use App\Entities\Outlet;
use App\Entities\Product;
use App\Entities\MyModel;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Repositories\CronRepository;
use App\Repositories\ZoneRepository;
use App\Repositories\ChannelRepository;
use App\Repositories\SubChannelRepository;
use App\Repositories\OutletRepository;
use App\Repositories\VisitRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\MyModelRepository;
use App\Repositories\UserRepository;
use App\Repositories\ReportRepository;
use App\Repositories\ClusterRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class CronJobController extends Controller {

    protected $visitRepository;
    protected $userRepository;
    protected $modelRepository;
    protected $channelRepository;
    protected $subChannelRepository;
    protected $zoneRepository;
    protected $outletRepository;
    protected $categoryRepository;
    protected $reportRepository;
    protected $clusterRepository;
    protected $productRepository;
    protected $cronRepository;

    public function __construct(UserRepository $userRepository, VisitRepository $visitRepository, MyModelRepository $modelRepository, ChannelRepository $channelRepository, SubChannelRepository $subChannelRepository, ZoneRepository $zoneRepository, OutletRepository $outletRepository, CategoryRepository $categoryRepository, ReportRepository $reportRepository, ClusterRepository $clusterRepository, ProductRepository $productRepository, CronRepository $cronRepository) {

        $this->reportRepository = $reportRepository;
        $this->userRepository = $userRepository;
        $this->visitRepository = $visitRepository;
        $this->modelRepository = $modelRepository;
        $this->channelRepository = $channelRepository;
        $this->subChannelRepository = $subChannelRepository;
        $this->zoneRepository = $zoneRepository;
        $this->outletRepository = $outletRepository;
        $this->categoryRepository = $categoryRepository;
        $this->clusterRepository = $clusterRepository;
        $this->productRepository = $productRepository;

        $this->cronRepository = $cronRepository;
    }

    function update_ha_avialibility()
    {
        $start_date='2021-04-01';
        $date = 'm_date';

        $query = MyModel::select('visits.' . $date . ' as date', 'brands.name as brand_name',
            'bcc_models.av as av')
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->leftjoin('ha', 'products.id', '=', 'ha.product_id')
            ->leftjoin('outlets', 'ha.outlet_id', '=', 'outlets.id')
            ->where('visits.' . $date, '>=', $start_date);

        $res=$query->get();
        dd($res);
    }
    function update_tracking_oos($date = false) {

        $save = array();
        $date = date('Y-m-d');
        $visits = MyModel::leftjoin('visits', 'models.visit_id', '=', 'visits.id')
                ->leftjoin('products', 'models.product_id', '=', 'products.id')
                ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
                ->leftjoin('brands', 'models.brand_id', '=', 'brands.id')
                ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
                ->select('visits.date as date'
                        , 'models.product_id as product_id'
                        , 'visits.outlet_id as outlet_id'
                        , 'models.av as av')
                ->where('outlets.active', '=', 1)
                ->where('products.active', '=', 1)
                ->where('visits.date', '=', $date)
                ->where('brands.id', '=', env('brand_id'))
//                ->where('visits.monthly_visit','=', 0)
                ->whereNotNull('models.product_id')
                ->get();

        if (!empty($visits->toArray())) {
            foreach ($visits as $r) {
                $save['product_id'] = $r->product_id;
                $save['outlet_id'] = $r->outlet_id;
                $save['av'] = $r->av;
                $save['date'] = $r->date;
                $save['w_date'] = firstDayOf('week', new DateTime($r->date));
                $save['m_date'] = firstDayOf('month', new DateTime($r->date));
//                print_r($save);
//                echo'<br>';
//                echo'<br>';
                $this->cronRepository->save_oos_tracking($save);
            }
        }
    }

    function performance($date = false) {
        $save = array();
        $date = date('Y-m-d');

        $admins = $this->userRepository->getUsersByRole('Field Officer');
        //dd($admins);
        foreach ($admins as $admin) {
            $total_branding = 0;
            $admin_id = $admin->id;
            //$date = date('2017-11-29');
            $w_date = firstDayOf('week', new DateTime($date));
            $m_date = firstDayOf('month', new DateTime($date));

            $visits = $this->cronRepository->get_visits_by_admin($admin_id, $date);
            //dd($visits);
            $nb_visits = sizeof($visits);
            $worked_time = 0;
            $was_there = 1;
            if ($nb_visits != 0) {
                $channels = $this->channelRepository->getChannels();
                foreach ($channels as $ch) {
                    $channel_name = preg_replace("# #", "_", $ch->name);
                    $save[$channel_name] = $this->cronRepository->get_oos_fo($admin_id, $date, $ch->id)[0]->oos;

                    // =      
                }
//                $uhd = $this->cronRepository->get_oos($admin_id, $date, 1)->oos;
//                $gemo = $this->cronRepository->get_oos($admin_id, $date, 2)->oos;
//                $mg = $this->cronRepository->get_oos($admin_id, $date, 3)->oos;
//                $aziza = $this->cronRepository->get_oos($admin_id, $date, 4)->oos;

                $entry_time = $visits[0]->entry_time;
                $exit_time = $visits[$nb_visits - 1]->exit_time;

                if ($visits[0]->was_there == 0) {
                    $was_there = 0;
                }

                /*
                  if ($exit_time < $entry_time) {
                  echo 'exit';
                  $aux = $entry_time;
                  $entry_time = $exit_time;
                  $exit_time = $aux;
                  } else {
                  echo 'entry';
                  }
                 */

                $entryInSeconds = strtotime($entry_time) - strtotime('TODAY');
                $exitInSeconds = strtotime($exit_time) - strtotime('TODAY');

                foreach ($visits as $visit) {
                    $worked_time = $worked_time + $visit->worked_time;
                    $nb_branding = count(json_decode($visit->branding_pictures));
                    $total_branding = $total_branding + $nb_branding;
                }

                $worked_time = $worked_time / 1000;

                $save['id'] = false;
                $save['admin_id'] = $admin_id;
                //entry time in secondes
                $save['entry_time'] = $entryInSeconds;
                //exit time in secondes
                $save['exit_time'] = $exitInSeconds;
                $save['entry'] = $entry_time;
                $save['exit'] = $exit_time;
                $save['date'] = $date;
                $save['w_date'] = $w_date;
                $save['m_date'] = $m_date;
                //working hours in secondes
                $save['working_hours'] = $worked_time;
                // travel hours in seconds
                if ($nb_visits > 1) {

                    $save['travel_hours'] = ($exitInSeconds - $entryInSeconds) - $worked_time;
                } else {
                    $save['travel_hours'] = 0;
                }
//                $save['gemo'] = $gemo;
//                $save['uhd'] = $uhd;
//                $save['mg'] = $mg;
//                $save['aziza'] = $aziza;

                $save['nb_visits'] = $nb_visits;
                $save['total_branding'] = $total_branding;

                $save['was_there'] = $was_there;

                $this->cronRepository->save_fo_performance($save);
            }
            print_r($save);
            echo '<br>*********************</br>';
        }
    }

}
