<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use Lang;
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
use App\Repositories\CategoryRepository;
use App\Repositories\MyModelRepository;
use App\Repositories\UserRepository;
use App\Repositories\ReportRepository;
use App\Repositories\ClusterRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class FoReportController extends Controller {

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

    public function __construct(UserRepository $userRepository, VisitRepository $visitRepository, MyModelRepository $modelRepository, ChannelRepository $channelRepository, SubChannelRepository $subChannelRepository, ZoneRepository $zoneRepository, OutletRepository $outletRepository, CategoryRepository $categoryRepository, ReportRepository $reportRepository, ClusterRepository $clusterRepository) {
        parent::__construct();
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
    }

    public function foProfile() {
        $title = 'Field Officiers';
        $subTitle = 'Profiles  &&  Routing';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;
        $data['users'] = $this->userRepository->getUsersByRole('Field Officer');
        //dd($data['users']);
        $data['roles'] = array('Admin' => 'Admin', 'Field Officer' => 'Field Officer', 'Client' => 'Client');
        $date = new DateTime(date('y-m-d'));
        $data['first_day_of_week'] = firstDayOf('week', $date);
        //dd($first_day_of_week);
        return view('admin.field_officiers.foProfile', $data);
    }

    public function load_fo_routing(Request $request) {
        $user_id = $request->input('user_id');
        //dd($user_id);
        $date = new DateTime(date('y-m-d'));
        $first_day_of_week = firstDayOf('week', $date);
        $data['first_day_of_week'] = $first_day_of_week;
        $data['outlets'] = Outlet::where('admin_id', '=', $user_id)->where('active', 1)->get();
        //dd($data['outlets']);
        $data['user_id'] = $user_id;
        return view('admin.field_officiers.load_fo_routing', $data);
    }

    function performance(Request $request) {
        $title = 'Report';
        $subTitle = \Lang::get('project.MERCHANDISER_PERFORMANCE');

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;


        $date_types = array();
        $date_types['daily'] = 'Daily';
        $date_types['month'] = 'Monthly';
        $date_types['week'] = 'Weekly';
        $data['date_types'] = $date_types;

//        $start_date = ($request->input("start_date")) ? $request->input("start_date") : date('Y-m-d');
//        $end_date = ($request->input("end_date")) ? $request->input("end_date") : date('Y-m-d');
//        $date_type = ($request->input('date_type')) ? $request->input("date_type") : 'daily';
        $date_type = $request->input('date_type');

        if ($date_type == 'month') {
            $start_date = $request->input('start_date_m');
            $end_date = $request->input('end_date_m');
        } else if ($date_type == 'week') {
            $start_date = $request->input('start_date_w');
            $end_date = $request->input('end_date_w');
        } else {
            $start_date = $request->input("start_date");
            $end_date = $request->input("end_date");
        }

        $data['date_type'] = $date_type;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        if ($start_date && $end_date && $date_type) {
            $report_data = $this->reportRepository->get_fo_performance($date_type, $start_date, $end_date);
            $data['report_data'] = $report_data;
        }
        //dd($data['report_data']->toArray());
        return view('admin.field_officiers.performance_report', $data);
    }

    function Routing_trend(Request $request) {

        $title = 'Report';
        $subTitle = \Lang::get('project.PLAN_DE_ROUTE');
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $start_date = ($request->input('start_date')) ? $request->input("start_date") : date('Y-m-d');
        $end_date = ($request->input('end_date')) ? $request->input("end_date") : date('Y-m-d');
        $day = ($request->input('day')) ? $request->input("day") : date('Y-m-d');

        $data['day'] = $day;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['report_data'] = $this->reportRepository->get_routing_trend($day, $start_date, $end_date);
        return view('admin.field_officiers.routing_trend', $data);
    }

    function routing_survey(Request $request) {

        $title = 'Report';
        $subTitle = \Lang::get('project.ROUTING_SURVEY');

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $start_date = ($request->input('start_date_w')) ? $request->input("start_date_w") : date('Y-m-d');
        $end_date = ($request->input('end_date_w')) ? $request->input("end_date_w") : date('Y-m-d');
        $fo_id = ($request->input('fo_id')) ? $request->input("fo_id") : -1;

        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->pluck('name', 'id');
        //$fos->prepend('All Fos', -1);


        $data['fos'] = $fos;

        $data['fo_id'] = $fo_id;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['report_data'] = $this->reportRepository->get_routing_survey_data($fo_id, $start_date, $end_date);

        return view('admin.field_officiers.routing_survey', $data);
    }

    function gps_monitoring(Request $request) {

        $title = 'Report';
        $subTitle = \Lang::get('project.GPS_MONITORING');

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $date = ($request->input('date')) ? $request->input("date") : date('Y-m-d');
        $fo_id = ($request->input('fo_id')) ? $request->input("fo_id") : -1;

        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->pluck('name', 'id');
        //$fos->prepend('All Fos', -1);


        $data['fos'] = $fos;
        $data['fo_id'] = $fo_id;
        $data['date'] = $date;

        $data['GPS_from_visit'] = $this->reportRepository->get_gps_monitoring_data_from_visits($fo_id, $date);

        return view('admin.field_officiers.gps_monitoring', $data);
    }

    ////////////////Fo INFORMATION
    function fo_information_input(Request $request) {

        $title = 'INPUT';
        $subTitle = \Lang::get('project.INFORMATION_MERCHANDISER');

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->pluck('name', 'id');
        $data['fos'] = $fos;

        $date = ($request->input("date")) ? $request->input("date") : "";
        $tab_date = explode(",", $date);
        $data['date'] = $tab_date;

        $fo_id = ($request->input('fo_id')) ? $request->input("fo_id") : "";
        $data['fo_id'] = $fo_id;

        $type = ($request->input('type')) ? $request->input("type") : "";
        $data['type'] = $type;

        $note = ($request->input('note')) ? $request->input("note") : "";
        $data['note'] = $note;

        return view('admin.field_officiers.fo_information.input', $data);
    }

    function save_fo_information(Request $request) {

        $date = $request->input('date');
        $tab_date = explode(",", $date);

        $fo_id = $request->input('fo_id');

        $type = $request->input('type');

        $note = $request->input('note');

        $date_of_insertion_day = date('Y-m-d');

        foreach ($tab_date as $date) {
            $save['date'] = $date_of_insertion_day;
            $save['w_date'] = firstDayOf('week', new DateTime($date_of_insertion_day));
            $save['m_date'] = firstDayOf('month', new DateTime($date_of_insertion_day));
            $save['date_de_conge'] = $date;
            $save['admin_id'] = request()->session()->get('connected_user_id');
            $save['fo_id'] = $fo_id;
            $save['type'] = $type;
            $save['note'] = $note;
            $inserted_id = $this->reportRepository->save_fo_information($save);
        }

        request()->session()->flash('message', 'Informations have been saved successfully.');
        return redirect()->route('admin.fo_report.fo_information_input');
    }

    function fo_information_output($date = false) {
        $title = 'OUTPUT';
        $subTitle = \Lang::get('project.INFORMATION_MERCHANDISER');

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        if ($date == false)
            $date = date('Y-m-d');
        $data['default_date'] = $date;
        return view('admin.field_officiers.fo_information.output', $data);
    }

    public function get_events() {
        // Our Start and End Dates
        $events = $this->reportRepository->get_events();

        $data_events = array();
        foreach ($events as $r) {
            $data_events[] = array(
                "id" => $r->id,
                "title" => reverse_format($r->date_de_conge),
                "description" => $r->note,
                "start" => $r->date_de_conge
            );
        }
        echo json_encode(array("events" => $data_events));
        exit();
    }

    public function load_tab(Request $request) {
        //$fos = $this->auth->get_fo_list();

        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->pluck('name', 'id');
        $data['fos'] = $fos;

        $date = ($request->input('date')) ? $request->input('date') : date('Y-m-d');
        $data['date_js'] = $date;
        $events = $this->reportRepository->get_events_details_by_date($date);
        $data['events'] = $events;

        return view('admin.field_officiers.fo_information.load_tab_output', $data);
    }

    function update_fo_information_type(Request $request) {
        $save['id'] = $request->input('id');
        $save['type'] = $request->input('type');
        print_r($save);
        $this->reportRepository->update_event($save);
    }

    function update_fo_information_fo_id(Request $request) {
        $save['id'] = $request->input('id');
        $save['fo_id'] = $request->input('fo_id');
        print_r($save);
        $this->reportRepository->update_event($save);
    }

    function update_comment_fo_information(Request $request) {
//        $save_comment['id'] = $request->input('id'];
//        $save_comment['description'] = $request->input('coment_id'];
//
//        print_r($save_comment);
//        $this->Routing_model->save($save_comment);

        if ($request->ajax()) {

            $valueStr = $request->input('value') ? $request->input('value') : '';
            $new_nameStr = trim($valueStr);
            $result_arr['description'] = $new_nameStr;

            $data['id'] = $request->input('pk') ? $request->input('pk') : '';
            $data['note'] = $new_nameStr;
            $result_arr['description'] = $new_nameStr;
            $this->reportRepository->update_event($data);
        }
        echo json_encode($result_arr);
        exit;
    }

    function delete_fo_information($id, $date) {

        $this->reportRepository->delete_event($id);

        request()->session()->flash('message', 'Informations has been deleted successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.fo_report.fo_information_output', $date);
    }

}
