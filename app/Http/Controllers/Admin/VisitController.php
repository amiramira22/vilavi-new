<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Entities\User;
use App\Entities\Channel;
use App\Entities\Zone;
use App\Entities\Outlet;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Repositories\ZoneRepository;
use App\Repositories\ChannelRepository;
use App\Repositories\SubChannelRepository;
use App\Repositories\OutletRepository;
use App\Repositories\VisitRepository;
use App\Repositories\MyModelRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use FarhanWazir\GoogleMaps\GMaps;

class VisitController extends Controller {

    protected $visitRepository;
    protected $userRepository;
    protected $modelRepository;
    protected $channelRepository;
    protected $subChannelRepository;
    protected $zoneRepository;
    protected $outletRepository;

    public function __construct(UserRepository $userRepository, VisitRepository $visitRepository, MyModelRepository $modelRepository, ChannelRepository $channelRepository, SubChannelRepository $subChannelRepository, ZoneRepository $zoneRepository, OutletRepository $outletRepository) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->visitRepository = $visitRepository;
        $this->modelRepository = $modelRepository;

        $this->channelRepository = $channelRepository;
        $this->subChannelRepository = $subChannelRepository;
        $this->zoneRepository = $zoneRepository;
        $this->outletRepository = $outletRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title = \Lang::get('project.VISITES');
        $subTitle = \Lang::get('project.VISITES') . ' ' . \Lang::get('project.TEMPS_REEL');
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;


        $visit_types = array();
        $visit_types[-1] = 'Please Select';
        $visit_types[0] = 'daily';
        $visit_types[1] = 'shelf';
        $visit_types[2] = 'price';
        $data['visit_types'] = $visit_types;
        //$users = $this->userRepository->getUsers(['id', 'name']);
        $users = $this->userRepository->getUsersByRole('Field Officer');
        $users = $users->pluck('name', 'id');
        $users->prepend(\Lang::get('project.SELECT_ALL'), -1);

        $start_date = ($request->input("start_date")) ? $request->input("start_date") : '';
        $end_date = ($request->input("end_date")) ? $request->input("end_date") : '';
        $visit_type = ($request->input("visit_type")) ? $request->input("visit_type") : "-1";
        $fo_id = ($request->input("fo_id")) ? $request->input("fo_id") : "-1";


        $data['users'] = $users;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['visit_type'] = $visit_type;
        $data['fo_id'] = $fo_id;

        return view('admin.visits.form_visit', $data);
    }

    public function getVisits(Request $request) {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        //dd($start_date);
        $visit_type = $request->input('visit_type');
        $fo_id = $request->input('fo_id');
        //echo($fo_id);
        $columns = array(
            0 => 'visits.id',
            1 => 'users.name',
            2 => 'outlets.name',
            3 => 'channels.name',
            4 => 'zones.name',
            5 => 'states.name',
            6 => 'visits.date',
            7 => 'visits.entry_time',
            8 => 'visits.exit_time',
            9 => 'visits.oos_perc',
            10 => 'visits.shelf_perc',
            11 => 'visits.remark',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $draw = $request->input('draw');
        $search = $request->input('search.value');

        if (empty($search)) {
            $search = '-1';
        } else {
            $search = $request->input('search.value');
        }
        //echo ($search);
        $visits = $this->visitRepository->getAjaxVisits($start, $limit, $order, $dir, $draw, $search, $start_date, $end_date, $visit_type, $fo_id);
        //dd($visits);
        echo json_encode($visits);
    }

    public function create() {
        $title = 'visit';
        $subTitle = 'Creat Visit';
        return view('admin.visits.create', compact('title', 'subTitle'));
    }

    public function edit($id) {
        $title = 'visit';
        $subTitle = 'Edit Visit';
        $visit = $this->visitRepository->getVisitById($id);

        //$users = $this->userRepository->getUsers(['id', 'name']);
        $users = $this->userRepository->getUsersByRole('Field Officer');
        $users = $users->pluck('name', 'id');
        $users->prepend($visit->user->name, $visit->user->id);

        $outlets = $this->outletRepository->listOutlets(['id', 'name']);
        $outlets = $outlets->pluck('name', 'id');
        $outlets->prepend($visit->outlet->name, $visit->outlet->id);


        return view('admin.visits.edit', compact('title', 'subTitle', 'visit', 'users', 'outlets'));
    }

    public function postVisit(Request $request) {
        $this->validate($request, [
            'fo_id' => 'string|max:255',
            'date' => 'date',
        ]);

        if ($request->input('id')) {
            $visit_id = $request->input('id');
            $visit = $this->visitRepository->getVisitById($visit_id);
        } else {
            $visit_id = '';
        }

        $date = $request->input('date');
        //dd($date);
        $w_date = firstDayOf('week', $date);
        $m_date = firstDayOf('month', $date);


        $save['date'] = $date;
        $save['w_date'] = $w_date;
        $save['m_date'] = $m_date;
        $save['admin_id'] = $request->input('fo_id');
        $save['outlet_id'] = $request->input('outlet_id');
        $save['uniqueId'] = $save['outlet_id'] . $save['admin_id'] . str_replace("-", "", $date) . $visit->entry_time;


        $save['remark'] = $request->input('remark');

        $id_visit_inserted = $this->visitRepository->addVisit($save, $visit_id);

        // Store data for only a single request and destory
        request()->session()->flash('message', 'Visit has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.visit.index');
    }

    public function delete($id) {
        $this->visitRepository->deleteVisit($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Visit has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.visit.index');
    }

    public function report($visit_id) {

        $title = 'report';
        $subTitle = 'Visit Report ';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $visit = $this->visitRepository->getVisitById($visit_id);

        if ($visit->monthly_visit == 0) {
            $models = $this->modelRepository->get_detail_daily_models($visit_id);
        } else {
            $models = $this->modelRepository->get_detail_models($visit_id);
        }
        //$models = $this->modelRepository->get_detail_daily_models($visit_id);
        //dd($models);
        $data['visit'] = $visit;
        $data['models'] = $models;
        $data['visit_id'] = $visit_id;
        $data['visit'] = $visit;


        return view('admin.visits.report', $data);
    }

    public function models($visit_id) {

        $title = 'models';
        $subTitle = 'List of Models';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;



        $visit = $this->visitRepository->getVisitById($visit_id);
        if ($visit->monthly_visit == 0) {
            $models = $this->modelRepository->get_detail_daily_models($visit_id);
        } else {
            $models = $this->modelRepository->get_detail_models($visit_id);
        }

        $data['visit'] = $visit;
        $data['models'] = $models;
        $data['visit_id'] = $visit_id;

        return view('admin.visits.models', $data);
    }

    public function postDataModel(Request $request) {

        $save['visit_id'] = $request->visit_id;
        $save['id'] = $request->model_id;
        $type = $request->type;
        $data = $request->data;

        if ($type == 'av') {
            $save['av'] = $data;
            $save['av_sku'] = $data;
        } else if ($type == 'shelf') {
            $save['shelf'] = $data;
        } else if ($type == 'price') {
            $save['price'] = $data;
        } else if ($type == 'promo_price') {
            $save['promo_price'] = $data;
        }

        $model = $this->modelRepository->checkModel($save['visit_id'], $save['id']);
        if ($model)
            $model_id = $model->id;
        else
            $model_id = '';

        $model_id = $this->modelRepository->addOrUpdateModel($save, $model_id);


        //update oos_perc or shelf_perc
        $visit_id = $request->visit_id;


        if ($type == 'av') {
            $count_model = $this->modelRepository->count_models_by_brand($visit_id, $brand_id = 1);
            $nb_oos = $this->modelRepository->get_nb_oos($visit_id);
            $oos_perc = $nb_oos / $count_model;
            echo $oos_perc;
//            echo '<br>';
//            echo $count_model;
            $save_visit['id'] = $visit_id;
            $save_visit['oos_perc'] = $oos_perc;
            $this->visitRepository->addVisit($save_visit, $visit_id);
        }

        if ($type == 'shelf') {
            $sum_shelf_henkel = $this->modelRepository->get_sum_shelf_henkel($visit_id)->total;
            $sum_all_shelf = $this->modelRepository->get_sum_shelf($visit_id)->total;

//            foreach ($sum_shelf as $value) {
//                $tot_shelf = $value->total;
//            }
            $shelf_perc = ($sum_shelf_henkel / $sum_all_shelf);


            echo 'sum_shelf_henkel   ' . $sum_shelf_henkel . '---';
            echo 'summ_all_shelf  ' . $sum_all_shelf . '---';
            echo $type . '----' . $shelf_perc . '---';


            $save_visit['id'] = $visit_id;
            $save_visit['shelf_perc'] = $shelf_perc;
            $this->visitRepository->addVisit($save_visit, $visit_id);
        }
        $response = array(
            'status' => 'success',
            'data' => $request->data,
            'type' => $request->type,
            'visit_id' => $request->visit_id,
            'model_id' => $request->model_id
        );
        return response()->json($response);
    }

    function copy($id = false) {
        $visit = $this->visitRepository->getVisitById($id);

        $data['id'] = false;
        $data['admin_id'] = $visit->admin_id;
        $data['outlet_id'] = $visit->outlet_id;
        $date = date("Y-m-d");

        $data['date'] = $date;
        $data['w_date'] = firstDayOf('week', $date);
        $data['m_date'] = firstDayOf('month', $date);
        $data['q_date'] = firstDayOf('quarter', $date);
        $data['monthly_visit'] = $visit->monthly_visit;
        //$data['shelf'] = $visit->shelf;
        $data['entry_time'] = $visit->entry_time;
        //$data['mobile_entry_time'] = $visit->mobile_entry_time;
        $data['exit_time'] = $visit->exit_time;
        //$data['mobile_exit_time'] = $visit->mobile_exit_time;
        $data['worked_time'] = $visit->worked_time;
        $data['remark'] = '';
        $data['oos_perc'] = $visit->oos_perc;
        $data['shelf_perc'] = $visit->shelf_perc;
        $data['longitude'] = $visit->longitude;
        //$data['exit_longitude'] = $visit->exit_longitude;
        $data['latitude'] = $visit->latitude;
        //$data['exit_latitude'] = $visit->exit_latitude;
        $data['active'] = $visit->active;
//        $data['uniqueId'] = $visit->uniqueId;
        $data['uniqueId'] = $visit->outlet_id . $visit->admin_id . str_replace("-", "", $date) . $visit->entry_time;


        $data['was_there'] = $visit->was_there;
        $data['branding_pictures'] = $visit->branding_pictures;
        $data['one_pictures'] = $visit->one_pictures;

        $copy_visit = $this->visitRepository->copy($data, $id);

        request()->session()->flash('message', 'Visit has been copied successfully.');
        return redirect()->route('admin.visit.models', $copy_visit);
    }

    public function extrait_journalier(Request $request) {
        $title = 'Visit Report';
        $subTitle = 'Daily Visit Report';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        //$users = $this->userRepository->getUsers(['id', 'name']);
        $users = $this->userRepository->getUsersByRole('Field Officer');
        $users = $users->pluck('name', 'id');
        $users->prepend('Please Select', -1);

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        $channels->prepend('Please Select', -1);

        $responsibles = $this->userRepository->getResponsibleList(['id', 'name']);
        $responsibles = $responsibles->pluck('name', 'id');
        $responsibles->prepend('Please Select', -1);

        $start_date = ($request->input("start_date")) ? $request->input("start_date") : date('Y-m-d');
        $fo_id = ($request->input("fo_id")) ? $request->input("fo_id") : "-1";
        $channel_id = ($request->input("channel_id")) ? $request->input("channel_id") : "-1";
        $resp_id = ($request->input("resp_id")) ? $request->input("resp_id") : "-1";


        $data['users'] = $users;
        $data['channels'] = $channels;
        $data['responsibles'] = $responsibles;

        $data['start_date'] = $start_date;

        $data['fo_id'] = $fo_id;
        if ($fo_id != -1)
            $data['fo_name'] = User::find($fo_id)->name;

        $data['channel_id'] = $channel_id;
        if ($channel_id != -1)
            $data['channel_name'] = Channel::find($channel_id)->name;


        $data['resp_id'] = $resp_id;
        if ($resp_id != -1)
            $data['resp_name'] = User::find($resp_id)->name;



        $report_data = $this->modelRepository->getAvDailyVisitReport($start_date, $fo_id, $channel_id, $resp_id);
        $data['report_data'] = $report_data;

        $outlets = array();
        $products = array();
        $components = array();
        foreach ($report_data as $row) {
            if (!in_array($row['product_id'], $products)) {
                $products[] = $row['product_id'];
            }
            //create an array for every date and the count at a location
            $components[$row['outlet_id']][$row['product_id']] = $row['av'];
        }

        //$data['outlets'] = $outlets;
        $data['products'] = $products;
        $data['components'] = $components;

        return view('admin.visits.extrait_journalier', $data);
    }

    public function historique_pdv(Request $request) {

        $title = 'Visit Report';
        $subTitle = 'Pos Data Report';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        $channels->prepend('Please Select', -1);

        $zones = $this->zoneRepository->listZones(['id', 'name']);
        $zones = $zones->pluck('name', 'id');
        $zones->prepend('Please Select', -1);

        $outlets = $this->outletRepository->listOutlets(['id', 'name']);
        $outlets = $outlets->pluck('name', 'id');
        //$outlets->prepend('Please Select', -1);

        $start_date = ($request->input("start_date")) ? $request->input("start_date") : date('Y-m-d');
        $end_date = ($request->input("end_date")) ? $request->input("end_date") : date('Y-m-d');
        $channel_id = ($request->input("channel_id")) ? $request->input("channel_id") : "-1";
        $zone_id = ($request->input("zone_id")) ? $request->input("zone_id") : "-1";
        $outlet_id = ($request->input("outlet_id")) ? $request->input("outlet_id") : "-1";

        $data['outlets'] = $outlets;
        $data['channels'] = $channels;
        $data['zones'] = $zones;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['zone_id'] = $zone_id;
        if ($zone_id != -1)
            $data['zone_name'] = Zone::find($zone_id)->name;

        $data['channel_id'] = $channel_id;
        if ($channel_id != -1)
            $data['channel_name'] = Channel::find($channel_id)->name;

        $data['outlet_id'] = $outlet_id;
        if ($outlet_id != -1)
            $data['outlet_name'] = Outlet::find($outlet_id)->name;

        if ($outlet_id != -1) {
            $report_data = $this->modelRepository->getPosData($start_date, $end_date, $outlet_id, $channel_id, $zone_id);
            $data['report_data'] = $report_data;

            $dates = array();
            $components = array();
            foreach ($report_data as $row) {

                $date = $row['date'];
                if (!in_array($date, $dates)) {
                    $dates[] = $date;
                }
                $components[$row['brand_name'] . '_' . $row['product_name']][$date] = $row['av'];
            }

            $data['dates'] = $dates;
            $data['components'] = $components;
        }
        return view('admin.visits.historique_pdv', $data);
    }

    function position($visit_id, $type = 'all') {
        $title = 'Visit';
        $subTitle = 'Daily Visit Position Details';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $visit = $this->visitRepository->getVisitById($visit_id);
        $outlet = $this->outletRepository->getOutletById($visit->outlet_id);

        $this->gmap = new GMaps;

        //map
        $config['center'] = $outlet->latitude . ',' . $outlet->longitude;
        $config['zoom'] = '15';
        $config['map_name'] = 'map_one';
        $config['map_div_id'] = 'map_canvas_one';
        $config['styles'] = array(
            array("name" => "Red Parks", "definition" =>
                array(array("featureType" => "all", "stylers" =>
                        array(array("saturation" => "-30"))),
                    array("featureType" => "poi.park", "stylers" =>
                        array(array("saturation" => "10"),
                            array("hue" => "#990000"))))),
            array("name" => "Black Roads", "definition" =>
                array(array("featureType" => "all", "stylers" =>
                        array(array("saturation" => "-70"))),
                    array("featureType" => "road.arterial", "elementType" => "geometry", "stylers" =>
                        array(array("hue" => "#000000"))))),
            array("name" => "No Businesses", "definition" =>
                array(array("featureType" => "poi.business", "elementType" => "labels", "stylers" =>
                        array(array("visibility" => "off"))))));


        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $config['https'] = true;
        $this->gmap->initialize($config);

        //position outlet 
        if ($type == 'all') {
            $content = '<b>Outlet position:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone . '</br><b>State:</b> '
                    . $outlet->state . ' </br> ';
            $marker['infowindow_content'] = $content;
            $marker['icon'] = url('assets/img/blue1.png');
            $marker['position'] = $outlet->latitude . ',' . $outlet->longitude;
            $this->gmap->add_marker($marker);

            $content = '<b>visit entry position:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone
                    . '</br><b>State:</b> ' . $outlet->state . ' </br> ';
            $marker1['infowindow_content'] = $content;
            $marker1['icon'] = url('assets/img/yellow1.png');
            $marker1['position'] = $visit->latitude . ',' . $visit->longitude;
            $this->gmap->add_marker($marker1);

            $content = '<b>visit exit position:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone . '</br><b>State:</b> '
                    . $outlet->state . ' </br> ';
            $marker2['infowindow_content'] = $content;
            $marker2['icon'] = url('assets/img/red1.png');
            $marker2['position'] = $visit->exit_latitude . ',' . $visit->exit_longitude;
            $this->gmap->add_marker($marker2);
        }
        // entry position
        elseif ($type == 'entry') {
            $content = '<b>Outlet position:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone . '</br><b>State:</b> '
                    . $outlet->state . ' </br> ';
            $marker['infowindow_content'] = $content;
            $marker['icon'] = url('assets/img/blue1.png');
            $marker['position'] = $outlet->latitude . ',' . $outlet->longitude;
            $this->gmap->add_marker($marker);

            $content = '<b>visit entry position:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone
                    . '</br><b>State:</b> ' . $outlet->state . ' </br> ';
            $marker1['infowindow_content'] = $content;
            $marker1['icon'] = url('assets/img/yellow1.png');
            $marker1['position'] = $visit->latitude . ',' . $visit->longitude;
            $this->gmap->add_marker($marker1);
        }
        // exit position
        else if ($type == 'exit') {
            $content = '<b>Outlet position:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone . '</br><b>State:</b> '
                    . $outlet->state . ' </br> ';
            $marker['infowindow_content'] = $content;
            $marker['icon'] = url('assets/img/blue1.png');
            $marker['position'] = $outlet->latitude . ',' . $outlet->longitude;
            $this->gmap->add_marker($marker);

            $content = '<b>visit exit position:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone . '</br><b>State:</b> '
                    . $outlet->state . ' </br> ';
            $marker2['infowindow_content'] = $content;
            $marker2['icon'] = url('assets/img/red1.png');
            $marker2['position'] = $visit->exit_latitude . ',' . $visit->exit_longitude;
            $this->gmap->add_marker($marker2);
        }

        $data['maps'] = $this->gmap->create_map();

        return view('admin.visits.position', $data);
    }

    function getOutletByZoneChannel(Request $request) {
        $channel_id = ($request->input("channel_id")) ? $request->input("channel_id") : "-1";
        $zone_id = ($request->input("zone_id")) ? $request->input("zone_id") : "-1";

        header('Content-Type: application/x-json; charset=utf-8');
        $outlets = array();
        //$outlets[-1] = 'All Outlets';
        foreach ($this->outletRepository->getOutletByZoneChannel($zone_id, $channel_id) as $outlet) {
            $outlets[$outlet->id] = $outlet->name;
        }
        echo(json_encode($outlets));
    }

    public function branding(Request $request) {

        $title = 'Report';
        $subTitle = 'Branding';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->pluck('name', 'id');
        $fos->prepend('Please Select', -1);

        $zones = $this->zoneRepository->listZones(['id', 'name']);
        $zones = $zones->pluck('name', 'id');
        $zones->prepend('Please Select', -1);

        $outlets = $this->outletRepository->listOutlets(['id', 'name']);
        $outlets = $outlets->pluck('name', 'id');
        $outlets->prepend('Please Select', -1);

        $start_date = ($request->input("start_date")) ? $request->input("start_date") : "";
        $end_date = ($request->input("end_date")) ? $request->input("end_date") : "";
        $fo_id = ($request->input("fo_id")) ? $request->input("fo_id") : "-1";
        $zone_id = ($request->input("zone_id")) ? $request->input("zone_id") : "-1";
        $outlet_id = ($request->input("outlet_id")) ? $request->input("outlet_id") : "-1";

        $data['outlets'] = $outlets;
        $data['fos'] = $fos;
        $data['zones'] = $zones;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['zone_id'] = $zone_id;
        if ($zone_id != -1)
            $data['zone_name'] = Zone::find($zone_id)->name;

        $data['fo_id'] = $fo_id;
        if ($fo_id != -1)
            $data['fo_name'] = User::find($fo_id)->name;

        $data['outlet_id'] = $outlet_id;
        if ($outlet_id != -1)
            $data['outlet_name'] = Outlet::find($outlet_id)->name;
        if ($start_date != '' && $end_date != '') {
            $branding_report = $this->visitRepository->get_branding_data($start_date, $end_date, $outlet_id, $fo_id, $zone_id);
//$branding_report = $branding_report->toArray();
//dd($data['branding_report']);
            $data['branding_report'] = $branding_report;
        }
        return view('admin.visits.branding', $data);
    }

    function getOutletByZoneFo(Request $request) {
        $fo_id = ($request->input("fo_id")) ? $request->input("fo_id") : "-1";
        $zone_id = ($request->input("zone_id")) ? $request->input("zone_id") : "-1";

        header('Content-Type: application/x-json; charset=utf-8');
        $outlets = array();
        $outlets[-1] = 'Please Select';
        foreach ($this->outletRepository->getOutletByZoneFo($zone_id, $fo_id) as $outlet) {
            $outlets[$outlet->id] = $outlet->name;
        }
        echo(json_encode($outlets));
    }

    // Tracking Shelf share visits reports
    function trackingVisitsReport(Request $request) {

        $title = 'Reports';
        $subTitle = 'Tracking Visits report';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $users = $this->userRepository->getUsersByRole('Field Officer');
        $users = $users->pluck('name', 'id');
        $users->prepend(\Lang::get('project.SELECT_ALL'), -1);
        $data['users'] = $users;

        $start_date = ($request->input("start_date")) ? $request->input("start_date") : date('Y-m-01');
        $end_date = ($request->input("end_date")) ? $request->input("end_date") : date('Y-m-30');
        $fo_id = ($request->input("fo_id")) ? $request->input("fo_id") : "-1";

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['fo_id'] = $fo_id;


        if ($start_date != '' && $end_date != '') {
            $data['visited_outlets'] = $this->visitRepository->get_tracking_visited_data($start_date, $end_date, $fo_id);
            $data['unvisited_outlets'] = $this->visitRepository->get_tracking_unvisited_data($start_date, $end_date, $fo_id);
            //dd($data['visited_outlets']);
        } else {
            $data['visited_outlets'] = array();
            $data['unvisited_outlets'] = array();
        }

        return view('admin.visits.tracking_visits_report', $data);
    }

}
