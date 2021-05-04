<?php

//beemerch

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DashboardRepository;
use App\Repositories\UserRepository;
use App\Repositories\OutletRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ChannelRepository;
use App\Entities\Outlet;
use App\Entities\Visit;
use App\Entities\Brand;
use DateTime;
use FarhanWazir\GoogleMaps\GMaps;
use App;
use Auth;
use Session;

class DashboardController extends Controller
{

    protected $gmap;
    protected $dashboardRepository;
    protected $userRepository;
    protected $outletRepository;
    protected $channelRepository;

    public function __construct(DashboardRepository $dashboardRepository, UserRepository $userRepository, OutletRepository $outletRepository, GMaps $gmap, ChannelRepository $channelRepository)
    {
        parent::__construct();

        $this->dashboardRepository = $dashboardRepository;
        $this->userRepository = $userRepository;
        $this->outletRepository = $outletRepository;
        $this->channelRepository = $channelRepository;

        $this->gmap = $gmap;
    }

    public function index()
    {

        $title = 'Dashboard';
        $subTitle = 'STATICS';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $data['count_outlet'] = Outlet::where('active', '=', '1')->count();

        $data['count_daily_visits'] = Visit::where('date', '=', date('Y-m-d'))->count();
        $data['count_target_daily_visits'] = Outlet::where('active', '=', '1')
            ->where('visit_day', 'like', '%' . date('l', strtotime('today')) . '%')->count();

        $data['count_monthly_visits'] = Visit::where('m_date', '=', date('Y-m-01'))->count();

        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->toArray();
        $data['fos'] = $fos;
//        if (is_array($fos))
//            dd($fos);
        $data['count_target_monthly_visits'] = count_target_monthly_visits($fos, date('Y-m-01'));
        $data['feeds'] = $this->dashboardRepository->get_monthly_remarks_visits();


        $config['center'] = '35.0534864,9.2408933';
        $config['zoom'] = '7';
        $config['styles'] = array(array("name" => "Red Parks", "definition" => array(array("featureType" => "all", "stylers" => array(array("saturation" => "-30"))), array("featureType" => "poi.park", "stylers" => array(array("saturation" => "10"), array("hue" => "#990000"))))), array("name" => "Black Roads", "definition" => array(array("featureType" => "all", "stylers" => array(array("saturation" => "-70"))), array("featureType" => "road.arterial", "elementType" => "geometry", "stylers" => array(array("hue" => "#000000"))))), array("name" => "No Businesses", "definition" => array(array("featureType" => "poi.business", "elementType" => "labels", "stylers" => array(array("visibility" => "off"))))));
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $config['https'] = true;
        $this->gmap->initialize($config);

        $today_visits = $this->dashboardRepository->get_today_visits();

        foreach ($today_visits as $visit) {

            //$outlet = $this->Outlet_model->get_outlet($visit->outlet_id);

            $content = '<b>Outlet name:</b> ' . $visit->outlet_name
                . '</br><b>Zone:</b> ' . $visit->zone_name
                . '</br><b>State:</b> ' . $visit->state_name
                . ' </br><b>Field officer:</b> ' . $visit->fo_name
               . ' </br><b></b><a class="m--font-info green filter-submit margin-bottom" href="' . url('visit/report/' . $visit->visit_id) . ' " data-toggle="tooltip" data-placement="top" title="Visit details" target="_blank">Show visit details</a>';

            $marker['infowindow_content'] = $content;

            if ($visit->channel_id == 1 && $visit->active == 1) {
                $marker['icon'] = url('assets/img/red1.png');
            } //UHD
            else if ($visit->channel_id == 2 && $visit->active == 1) {
                $marker['icon'] = url('assets/img/blue1.png');
            } //MG
            else if ($visit->channel_id == 3 && $visit->active == 1) {
                $marker['icon'] = url('assets/img/yellow1.png');
            } //MG
            else if ($visit->channel_id == 'MG' && $visit->active == 1) {
                $marker['icon'] = url('assets/img/green1.png');
            } //Traditional trade
            else if ($visit->channel_id == 4 && $visit->active == 1) {
                $marker['icon'] = url('assets/img/yellow1.png');
            }
            $marker['position'] = $visit->latitude . ',' . $visit->longitude;
            $this->gmap->add_marker($marker);
        }
        $data['maps'] = $this->gmap->create_map();

        return view('dashboard.index', $data);
    }

    function load_oos_peer_channel()
    {

        $data['brands'] = Brand::where('selected', '=', '1')->get();
        $date = date('Y-m-01');
        $data['oos_per_channel_data'] = $this->dashboardRepository->get_oos_per_channel(env('brand_id'), $date);
        return view('dashboard.load_oos_per_channel', $data);
    }

    function load_chart_oos_per_channel(Request $request)
    {

        $brand_id = $request->input('brand_id');
        $date = date('Y-m-01');
        $data['brand_id'] = $brand_id;
        $data['oos_per_channel_data'] = $this->dashboardRepository->get_oos_per_channel($brand_id, $date);
        return view('dashboard.chart_oos_per_channel', $data);
    }

    function load_oos_peer_category()
    {

        $data['brands'] = Brand::where('selected', '=', '1')->get();
        $date = date('Y-m-01');
        $data['oos_per_category_data'] = $this->dashboardRepository->get_oos_per_category(env('brand_id'), $date);
        //dd( $data['oos_per_category_data']);
        return view('dashboard.load_oos_per_category', $data);
    }

    function load_chart_oos_per_category(Request $request)
    {

        $data['brands'] = Brand::where('selected', '=', '1')->get();
        $date = date('Y-m-01');
        $brand_id = $request->input('brand_id');
        $data['brand_id'] = $brand_id;
        $data['oos_per_category_data'] = $this->dashboardRepository->get_oos_per_category($brand_id, $date);
        //dd( $data['oos_per_category_data']);
        return view('dashboard.chart_oos_per_category', $data);
    }

    function load_numeric_distribution(Request $request)
    {

        $data['brands'] = Brand::where('selected', '=', '1')->get();
        $date = date('Y-m-01');
        $brand_id = ($request->input('brand_id')) ? $request->input('brand_id') : env('brand_id');
        $data['brand_id'] = $brand_id;
        $data['numeric_distribution_data'] = $this->dashboardRepository->get_data_numeric_distribution($brand_id, $date);
        //dd( $data['numeric_distribution_data']);
        return view('dashboard.load_numeric_distribution', $data);
    }

    function load_chart_numeric_distribution(Request $request)
    {

        $data['brands'] = Brand::where('selected', '=', '1')->get();
        $date = date('Y-m-01');
        $brand_id = $request->input('brand_id');
        $data['brand_id'] = $brand_id;
        $data['numeric_distribution_data'] = $this->dashboardRepository->get_data_numeric_distribution($brand_id, $date);
        //dd( $data['numeric_distribution_data']);
        return view('dashboard.chart_numeric_distribution', $data);
    }

    function load_top_5_oos()
    {
        date_default_timezone_set('Europe/Amsterdam');
        $date = new DateTime();

        //*************************** les 4 weeks du mois courant **********************************************************
        $date->modify('this week');
        $date_this_week = $date->format('Y-m-d');

        $date->modify('this week -7 days');
        $date_last_week = $date->format('Y-m-d');

        $date->modify('this week -7 days');
        $date_last2_week = $date->format('Y-m-d');

        $date->modify('this week -7 days');
        $date_last3_week = $date->format('Y-m-d');
        //*******************************************************************************************************************
        $prod_this_week = $this->dashboardRepository->get_top_products_by_date($date_this_week, 0);
        //dd($prod_this_week);
        $data['date_this_week'] = $date_this_week;
        $data['date_last_week'] = $date_last_week;
        $data['date_last2_week'] = $date_last2_week;
        $data['date_last3_week'] = $date_last3_week;
        $data['prod_this_week'] = $prod_this_week;


        return view('dashboard.load_top_5_oos', $data);
    }

    //appel js
    function load_top_oos_products(Request $request)
    {
        $date = $request->input('date');
        $data['date'] = $date;
        $data['prod_this_week'] = $this->dashboardRepository->get_top_products_by_date($date, 0);
        return view("dashboard.dashboard_top_oos_products_peer_week", $data);
    }

    function top_oos_all_products($date)
    {

        $title = '';
        $subTitle = '';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $data['date'] = $date;
        $data['products'] = $this->dashboardRepository->get_top_products_by_date($date, 1);
        return view("dashboard.top_oos_all_products", $data);
    }

    function load_oos_trend()
    {
        $data['categories'] = \App\Entities\Category::where('active', '=', '0')->get();
        $result = $this->dashboardRepository->get_data_oos_of_trend(7);
        //dd($result);
        $data['components'] = $result['components'];
        $data['dates'] = $result['dates'];

        return view("dashboard.load_oos_trend", $data);
    }

    function load_chart_oos_trend(Request $request)
    {
        $category_id = $request->input('category_id');
        $result = $this->dashboardRepository->get_data_oos_of_trend($category_id);
        $data['category_id'] = $category_id;
        $data['components'] = $result['components'];
        $data['dates'] = $result['dates'];
        return view("dashboard.chart_oos_trend", $data);
    }

    function outlets_details()
    {
        $title = 'Dashboard';
        $subTitle = 'Active outlets details';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;
        $data['all_outlets'] = Outlet::where('active', '=', '1')->count();
        $data['channels'] = $this->channelRepository->getChannels();
        $data['active_outlets'] = $this->dashboardRepository->get_outlet_by_state_classe_details();

        $data['outlets_by_state'] = $this->dashboardRepository->get_outlets_by_states()->toArray();
        $data['outlets_by_channel'] = $this->dashboardRepository->get_outlets_by_channels()->toArray();


        return view("dashboard.outlets_details", $data);
    }

    function daily_details(Request $request)
    {
        $title = 'Dashboard';
        $subTitle = 'Daily details';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $start_date = ($request->input('start_date')) ? $request->input("start_date") : date('Y-m-d');
        $end_date = ($request->input('end_date')) ? $request->input("end_date") : date('Y-m-d');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;


        $data['daily_visits_details_by_fo'] = $this->dashboardRepository->get_daily_visit_details($start_date, $end_date, 'admin.id');
        $data['daily_visits_details_by_channel'] = $this->dashboardRepository->get_daily_visit_details($start_date, $end_date, 'channels.id');
        //dd($data['daily_visits_details_by_fo'], $data['daily_visits_details_by_channel']);
        return view("dashboard.daily_details", $data);
    }

    function monthly_details(Request $request)
    {
        $title = 'Dashboard';
        $subTitle = 'Monthly details';

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $date = ($request->input('start_date_m')) ? $request->input("start_date_m") : date('Y-m-01');
        $data['date'] = $date;

        $data['monthly_visits_details'] = $this->dashboardRepository->get_monthly_visit($date);
        return view("dashboard.monthly_details", $data);
    }

}
