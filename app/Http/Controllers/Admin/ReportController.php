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
use App\Entities\Product;
use DateTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Repositories\ProductGroupRepository;
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
use FarhanWazir\GoogleMaps\GMaps;

use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{

    protected $gmap;
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
    protected $productGroupRepository;

    public function __construct(UserRepository $userRepository, VisitRepository $visitRepository, MyModelRepository $modelRepository, ChannelRepository $channelRepository, SubChannelRepository $subChannelRepository, ZoneRepository $zoneRepository, OutletRepository $outletRepository, CategoryRepository $categoryRepository, ReportRepository $reportRepository, ClusterRepository $clusterRepository, ProductRepository $productRepository, ProductGroupRepository $productGroupRepository, GMaps $gmap)
    {
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
        $this->productRepository = $productRepository;
        $this->productGroupRepository = $productGroupRepository;

        $this->gmap = $gmap;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function numeric_distribution(Request $request)
    {

//$data['components'] = array();
//$data['dates'] = array();
//$data['zone_components'] = array();

        $title = 'DN Report';
        $subTitle = \Lang::get('project.DISTRIBUTION_NUMERIQUE');

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $report_data = array();
        $multi_date = 0;
        $multi_zone = 0;
        $multi_channel = 0;

        $date_types = array();
        $date_types['month'] = 'Monthly';
        $date_types['week'] = 'Weekly';
        $date_types['quarter'] = 'Quarter';
        $data['date_types'] = $date_types;

        $quarter_dates = array();
        $quarter_dates['01-01'] = 'Q1';
        $quarter_dates['04-01'] = 'Q2';
        $quarter_dates['07-01'] = 'Q3';
        $quarter_dates['10-01'] = 'Q4';
        $data['quarter_dates'] = $quarter_dates;

        $categories = $this->categoryRepository->listCategories(['id', 'name']);
        $categories = $categories->pluck('name', 'id');
        $categories->prepend('Please select', -1);

//$zones = $this->zoneRepository->getZones();
//$channels = $this->channelRepository->getChannels();
        $zones_of_select = $this->zoneRepository->listZones(['id', 'name']);
        $zones_of_select = $zones_of_select->pluck('name', 'id');
        $zones_of_select->prepend('Please select', -1);

        $channels_of_select = $this->channelRepository->listChannels(['id', 'name']);
        $channels_of_select = $channels_of_select->pluck('name', 'id');
        $channels_of_select->prepend('Please select', -1);

        $data['categories'] = $categories;
        $data['zones_of_select'] = $zones_of_select;
        $data['channels_of_select'] = $channels_of_select;


        $start_date = ($request->input("start_date")) ? $request->input("start_date") : "";
        $end_date = ($request->input("end_date")) ? $request->input("end_date") : "";
        $date_type = $request->input("date_type");
        $category_id = ($request->input("category_id")) ? $request->input("category_id") : "-1";

        if ($category_id != '-1') {
            $data['clusters'] = $this->clusterRepository->get_clusters_by_category($category_id);
//dd($data['clusters']);
        }


        $selected_zone_ids = $request->input('selected_zone_ids');
        $selected_channel_ids = $request->input('selected_channel_ids');

        $data['selected_zone_ids'] = $selected_zone_ids;
        $data['selected_channel_ids'] = $selected_channel_ids;

        $data['json_zone_ids'] = json_encode($selected_zone_ids);
        $data['json_channel_ids'] = json_encode($selected_channel_ids);


        if ($date_type == 'month') {
            $start_date = $request->input('start_date_m');
            $end_date = $request->input('end_date_m');
        } else if ($date_type == 'week') {
            $start_date = $request->input('start_date_w');
            $end_date = $request->input('end_date_w');
        } else if ($date_type == 'quarter') {
            $year1 = $request->input('year1');
            $quarter1 = $request->input('quarter1');

            $year2 = $request->input('year2');
            $quarter2 = $request->input('quarter2');

            $start_date = $year1 . '-' . $quarter1;
            $end_date = $year2 . '-' . $quarter2;
        }

        if ($start_date != $end_date) {
            $multi_date = 1;
        }
        if (!empty($selected_zone_ids)) {
            $multi_zone = 1;
        }

        if (!empty($selected_channel_ids)) {
            $multi_channel = 1;
        }

        if ($start_date && $end_date) {

// Multi Date 
            if ($multi_date && !$multi_zone && !$multi_channel) {
                $data['report_data'] = $this->reportRepository->get_av_multi_date_brand($date_type, $start_date, $end_date, $category_id, '-1', '-1');
//dd($data['report_data']);
                $dates = array();
                $components = array();
                $date_components = array();
                $count_date = 0;
                $brand_colors = array();

                foreach ($data['report_data'] as $row) {
                    $date = $row['date'];
                    if (!in_array($date, $dates)) {
                        $dates[] = $date;
                        $count_date += 1;
                    }

                    $brand_colors[$row['brand_name']] = $row['brand_color'];
//create an array for every brand and the count at a outlet
                    $components[$row['brand_name']][$date] = array($row['av'], $row['oos'], $row['ha']);
                    $date_components[$date] [$row['brand_name']] = $row['oos'];
                }

                $data['brand_colors'] = $brand_colors;
                $data['components'] = $components;
                $data['date_components'] = $date_components;
                $data['dates'] = $dates;
            }


//****************************************************************************************************                
            // Single Date only
            else if (!$multi_date && !$multi_zone && !$multi_channel) {
                // Meme traitement que multi date !
                $data['report_data'] = $this->reportRepository->get_av_multi_date_brand($date_type, $start_date, $end_date, $category_id, '-1', '-1');
                $dates = array();
                $components = array();
                foreach ($data['report_data'] as $row) {

                    $date = $row['date'];
                    if (!in_array($date, $dates)) {
                        $dates[] = $date;
                    }
                    $components[$row['brand_name']][$date] = array($row['av'], $row['oos'], $row['ha']);
                }
                $data['components'] = $components;
                $data['dates'] = $dates;
            } // Single Date + Multi Zones
            else if (!$multi_date && $multi_zone) {
                $data['report_data'] = $this->reportRepository->get_av_single_date_brand_zones($date_type, $start_date, $end_date, $category_id, $selected_zone_ids, $selected_channel_ids);

                //dd($data['report_data']);
                $zones = array();
                $components = array();
                $zone_components = array();

                foreach ($data['report_data'] as $row) {
                    $zone = $row['zone'];
                    if (!in_array($zone, $zones)) {
                        $zones[] = $zone;
                    }
                    //create an array for every brand and the count at a outlet
                    $components[$row['brand_name']][$zone] = array($row['av'], $row['oos'], $row['ha']);
                    $zone_components[$row['zone']][$row['brand_name']] = array($row['av'], $row['oos'], $row['ha']);
                }

                $data['components'] = $components;
                $data['zone_components'] = $zone_components;
                $data['zones'] = $zones;
            } // Single Date + Multi Outlet Types
            else if (!$multi_date && !$multi_zone && $multi_channel) {
                $data['report_data'] = $this->reportRepository->get_av_single_date_brand_channels($date_type, $start_date, $end_date, $category_id, $selected_zone_ids, $selected_channel_ids);
                $channels = array();
                $components = array();
                $channel_components = array();

                foreach ($data['report_data'] as $row) {
                    $channel = $row['channel'];
                    if (!in_array($channel, $channels)) {
                        $channels[] = $channel;
                    }
                    //create an array for every brand and the count at a outlet
                    $components[$row['brand_name']][$channel] = array($row['av'], $row['oos'], $row['ha']);
                    $channel_components[$channel][$row['brand_name']] = array($row['av'], $row['oos'], $row['ha']);
                }
                $data['components'] = $components;
                $data['channel_components'] = $channel_components;
                $data['channels'] = $channels;
            }
        }//end if ($start_date && $end_date)


        $data['multi_date'] = $multi_date;
        $data['multi_zone'] = $multi_zone;
        $data['multi_channel'] = $multi_channel;

        $data['date_type'] = $date_type;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['category_id'] = $category_id;


        return view('admin.report.numeric_distribution.form_report', $data);
    }

// Foreach cluster single date only or multi date only
//multi date + single date
//load_av_zone multi date
//load_av_channel multi date
    function load_av_cluster(Request $request)
    {
        //dd($request);
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date_type = $request->input('date_type');
        $category_id = $request->input('category_id');
        $cluster_id = $request->input('cluster_id');

        if (($request->input('json_channel_ids')))
            $channel_ids = json_decode($request->input('json_channel_ids'));
        else if (($request->input('channel_id')))
            $channel_ids = $request->input('channel_id');
//dd($channel_ids);
        $zone_ids = $request->input('zone_id');

        $data['cluster_id'] = $cluster_id;
        $data['date_type'] = $date_type;

        $data['out_val'] = $request->input('out_val');
        $data['zone_val'] = $request->input('zone_val');
//dd('amira');
        $data['report_data'] = $this->reportRepository->get_av_cluster($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids);
        //dd($data['report_data']);
        return view('admin.report.numeric_distribution.single_date.load_av_cluster', $data);
    }

    function load_av_cluster_zones(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date_type = $request->input('date_type');
        $category_id = $request->input('category_id');
        $cluster_id = $request->input('cluster_id');

        $zone_ids = json_decode($request->input('json_zone_ids'));
        $channel_ids = json_decode($request->input('json_channel_ids'));

        $data['cluster_id'] = $cluster_id;
        $data['out_val'] = $request->input('out_val');
        $data['zone_val'] = $request->input('zone_val');
        $data['report_data'] = $this->reportRepository->get_av_cluster_zones($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids);

        return view('admin.report.numeric_distribution.single_date.load_av_cluster_zones', $data);
    }

    function load_av_cluster_channels(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date_type = $request->input('date_type');
        $category_id = $request->input('category_id');
        $cluster_id = $request->input('cluster_id');

        $zone_ids = json_decode($request->input('json_zone_ids'));
        $channel_ids = json_decode($request->input('json_channel_ids'));

        $data['cluster_id'] = $cluster_id;
        $data['out_val'] = $request->input('out_val');
        $data['zone_val'] = $request->input('zone_val');
        $data['report_data'] = $this->reportRepository->get_av_cluster_channels($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids);

        return view('admin.report.numeric_distribution.single_date.load_av_cluster_channels', $data);
    }

    function load_av_zone(Request $request)
    {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date_type = $request->input('date_type');
        $category_id = $request->input('category_id');
        $zone_id = $request->input('zone_id');

        $channel_ids = json_decode($request->input('json_channel_ids'));
        $data['channel_ids'] = $channel_ids;
        $data['json_channel_ids'] = $request->input('json_channel_ids');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['date_type'] = $date_type;
        $data['category_id'] = $category_id;
        $data['zone_id'] = $zone_id;

        $data['zone_val'] = $request->input('zone_val');
        $data['out_val'] = $request->input('out_val');
        if ($category_id != '-1') {
            $data['clusters'] = $this->clusterRepository->get_clusters_by_category($category_id);
            //dd($data['clusters']);
        }
        $data['report_data'] = $this->reportRepository->get_av_multi_date_brand($date_type, $start_date, $end_date, $category_id, $zone_id, $channel_ids);
        //dd($data['report_data']);
        if (!empty($data['report_data']->toArray())) {
            $dates = array();
            $components = array();
            $date_components = array();
            $brand_colors = array();

            foreach ($data['report_data'] as $row) {
                $date = $row['date'];
                if (!in_array($date, $dates)) {
                    $dates[] = $date;
                }

                $brand_colors[$row['brand_name']] = $row['brand_color'];
//create an array for every brand and the count at a outlet
                $components[$row['brand_name']][$date] = array($row['av'], $row['oos'], $row['ha']);
                $date_components[$date] [$row['brand_name']] = number_format($row['oos'], 2, '.', ' ');
            }// end foreach report_data

            $data['brand_colors'] = $brand_colors;
            $data['components'] = $components;
            $data['date_components'] = $date_components;
            $data['dates'] = $dates;
            return view('admin.report.numeric_distribution.multi_date.load_av_zone', $data);
        }
    }

    function load_av_channel(Request $request)
    {
        //dd($request);
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $category_id = $request->input('category_id');
        $date_type = $request->input('date_type');
        $zone_id = $request->input('zone_id');
        $channel_id = $request->input('channel_id');

        $data['zone_id'] = $zone_id;
        $data['channel_id'] = $channel_id;

        $data['date_type'] = $date_type;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['category_id'] = $category_id;

        $data['out_val'] = $request->input('out_val');
        $data['zone_val'] = $request->input('zone_val');

        if ($category_id != '-1') {
            $data['clusters'] = $this->clusterRepository->get_clusters_by_category($category_id);
//dd($data['clusters']);
        }
        $data['report_data'] = $this->reportRepository->get_av_multi_date_brand($date_type, $start_date, $end_date, $category_id, -1, $channel_id);

        if (!empty($data['report_data']->toArray())) {
            $dates = array();
            $components = array();
            $date_components = array();
            $brand_colors = array();

            foreach ($data['report_data'] as $row) {
                $date = $row['date'];
                if (!in_array($date, $dates)) {
                    $dates[] = $date;
                }

                $brand_colors[$row['brand_name']] = $row['brand_color'];
//create an array for every brand and the count at a outlet
                $components[$row['brand_name']][$date] = array($row['av'], $row['oos'], $row['ha']);
                $date_components[$date] [$row['brand_name']] = number_format($row['oos'], 2, '.', ' ');
            }// end foreach report_data

            $data['brand_colors'] = $brand_colors;
            $data['components'] = $components;
            $data['date_components'] = $date_components;
            $data['dates'] = $dates;
            return view('admin.report.numeric_distribution.multi_date.load_av_channel', $data);
        }
    }

//hcm
    function extarait_pdv_dn_report(Request $request)
    {

        $title = 'Report';
        $subTitle = 'POS Stock Issues';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;


        $date_types['month'] = 'Monthly';
        $date_types['week'] = 'Weekly';
        //$date_types['quarter'] = 'Quarter';
        $data['date_types'] = $date_types;

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        //$channels->prepend('All Channels', -1);
        $data['channels'] = $channels;

        //r�cup�rer le formulaire 
        $date_type = $request->input("date_type");
        $channel_id = $request->input('channel_id');
        if ($date_type == 'month') {
            $start_date = $request->input('start_date_m');
            $end_date = $request->input('end_date_m');
            $data['subTitle'] = "POS Stock Issues Report | " . format_month($start_date) . ' --> ' . format_month($end_date);
        } else {
            $start_date = $request->input('start_date_w');
            $end_date = $request->input('end_date_w');
            $data['subTitle'] = "POS Stock Issues Report | " . format_week($start_date) . ' --> ' . format_week($end_date);
        }
        $data['date_type'] = $date_type;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['channel_id'] = $channel_id;

        if ($start_date && $end_date) {
            //limit
            $row = 0;

            //offset
            $rowperpage = 1;

            $categories = $this->categoryRepository->getLimitCategories($rowperpage, $row);
            //dd($categories);
            $category_id = $categories->first()->id;

            $data['allcount'] = $this->categoryRepository->countCategories();

            $data['report_data'] = $this->reportRepository->get_extarait_pdv_dn_per_category($date_type, $start_date, $end_date, $category_id, $channel_id);

            $outlets = array();
            $components = array();
            $product_ids = array();
            $count_products = 0;

            foreach ($data['report_data'] as $row) {

                $product_id = $row['product_id'];
                if (!in_array($product_id, $product_ids)) {
                    $product_ids[] = $product_id;
                    $count_products += 1;
                }
                //create an array for every brand and the count at a outlet
                $components[$row['outlet_id']][$product_id] = array($row['oos'], $row['ha'], $row['total'], $row['av']);
            }

            $data['components'] = $components;
            $data['outlets'] = $outlets;
            $data['categories'] = $categories;
            $data['product_ids'] = $product_ids;
        }
        return view('admin.report.numeric_distribution.extarait_pdv_dn_report', $data);
    }

    //AJAX CALL
    function load_extarait_pdv_dn_per_category(Request $request)
    {

        $date_type = $request->input('date_type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $channel_id = $request->input('channel_id');
        //$category_id = $request->input('category_id');

        $row = $request->input('row');
        $rowperpage = 1;

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['date_type'] = $date_type;
        $data['channel_id'] = $channel_id;

        $categories = $this->categoryRepository->getLimitCategories($rowperpage, $row);
        $data['categories'] = $categories;
        $category_id = $categories->first()->id;
//        $data['category_id'] = $category_id;

        $data['report_data'] = $this->reportRepository->get_extarait_pdv_dn_per_category($date_type, $start_date, $end_date, $category_id, $channel_id);
        $outlets = array();
        $components = array();
        $product_ids = array();
        $count_products = 0;
        foreach ($data['report_data'] as $row) {
            $product_id = $row['product_id'];
            if (!in_array($product_id, $product_ids)) {
                $product_ids[] = $product_id;
                $count_products += 1;
            }
            //create an array for every brand and the count at a outlet
            $components[$row['outlet_id']][$product_id] = array($row['oos'], $row['ha'], $row['total'], $row['av']);
        }
        $data['components'] = $components;
        $data['outlets'] = $outlets;
        $data['categories'] = $categories;
        $data['product_ids'] = $product_ids;
        return view('admin.report.numeric_distribution.load_extarait_pdv_dn_per_category', $data);
    }

    ////////////////////////////////////////////////////SHELF SHARE //////////////////////////////////////////////

    public function shelf_share(Request $request)
    {

        //$data['components'] = array();
        //$data['dates'] = array();
        //$data['zone_components'] = array();

        $title = 'Report';
        $subTitle = \Lang::get('project.PART_DE_LINEAIRE');

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $report_data = array();
        $date_types = array();
        $multi_date = 0;
        $multi_zone = 0;
        $multi_channel = 0;

        $date_types['month'] = 'Monthly';
        $date_types['week'] = 'Weekly';
        $date_types['quarter'] = 'Quarter';
        $data['date_types'] = $date_types;

        $quarter_dates = array();
        $quarter_dates['01-01'] = 'Q1';
        $quarter_dates['04-01'] = 'Q2';
        $quarter_dates['07-01'] = 'Q3';
        $quarter_dates['10-01'] = 'Q4';
        $data['quarter_dates'] = $quarter_dates;

        $categories = $this->categoryRepository->listCategories(['id', 'name']);
        $categories = $categories->pluck('name', 'id');
        $categories->prepend('Please select', -1);

        //$zones = $this->zoneRepository->getZones();
        //$channels = $this->channelRepository->getChannels();
        $zones_of_select = $this->zoneRepository->listZones(['id', 'name']);
        $zones_of_select = $zones_of_select->pluck('name', 'id');
        $zones_of_select->prepend('Please select', -1);

        $channels_of_select = $this->channelRepository->listChannels(['id', 'name']);
        $channels_of_select = $channels_of_select->pluck('name', 'id');
        $channels_of_select->prepend('Please select', -1);

        $data['categories'] = $categories;
        $data['zones_of_select'] = $zones_of_select;
        $data['channels_of_select'] = $channels_of_select;


        $start_date = ($request->input("start_date")) ? $request->input("start_date") : "";
        $end_date = ($request->input("end_date")) ? $request->input("end_date") : "";
        $date_type = $request->input("date_type");
        $category_id = ($request->input("category_id")) ? $request->input("category_id") : "-1";

        if ($category_id != '-1') {
            $data['clusters'] = $this->clusterRepository->get_clusters_by_category($category_id);
            //dd($data['clusters']);
        }
        $selected_zone_ids = $request->input('selected_zone_ids');
        $selected_channel_ids = $request->input('selected_channel_ids');

        $data['selected_zone_ids'] = $selected_zone_ids;
        $data['selected_channel_ids'] = $selected_channel_ids;

        $data['json_zone_ids'] = json_encode($selected_zone_ids);
        $data['json_channel_ids'] = json_encode($selected_channel_ids);


        if ($date_type == 'month') {
            $start_date = $request->input('start_date_m');
            $end_date = $request->input('end_date_m');
        } else if ($date_type == 'week') {
            $start_date = $request->input('start_date_w');
            $end_date = $request->input('end_date_w');
        } else if ($date_type == 'quarter') {
            $year1 = $request->input('year1');
            $quarter1 = $request->input('quarter1');

            $year2 = $request->input('year2');
            $quarter2 = $request->input('quarter2');

            $start_date = $year1 . '-' . $quarter1;
            $end_date = $year2 . '-' . $quarter2;
        }

        if ($start_date != $end_date) {
            $multi_date = 1;
        }
        if (!empty($selected_zone_ids)) {
            $multi_zone = 1;
        }

        if (!empty($selected_channel_ids)) {
            $multi_channel = 1;
        }

        if ($start_date && $end_date) {

            // Multi Date 
            if ($multi_date && !$multi_zone && !$multi_channel) {
                $data['report_data'] = $this->reportRepository->get_shelf_multi_date_brand($date_type, $start_date, $end_date, $category_id, '-1', '-1');
                // dd($data['report_data']);
                $dates = array();
                $count_date = 0;
                $components = array();
                $date_components = array();
                //$components_chart = array();
                //$brand_colors = array();

                foreach ($data['report_data'] as $row) {

                    $date = ($row['date']);
                    if (!in_array($date, $dates)) {
                        $dates[] = $date;
                        $count_date += 1;
                    }
                    $components[$row['brand_name']][$date] = $row['shelf'];
                    $date_components [$row['date']] [$row['brand_name']] = $row['shelf'];
//                    $components_chart[$row['brand_name']][$date] = $row['shelf'];
//                    $brand_colors[$row['brand_name']] = $row['brand_color'];
                }
                $sum_shelf_date = array();
                foreach ($date_components as $date => $componentBrand) {
                    $sum_shelf_date[$date] = array_sum(array_values($componentBrand));
                }
                $data['components'] = $components;
                $data['dates'] = $dates;
                $data['sum_shelf_date'] = $sum_shelf_date;

//                $data['brand_colors'] = $brand_colors;
//                $data['date_components'] = $date_components;
            }
//****************************************************************************************************                
            // Single Date only
            if (!$multi_date && !$multi_zone && !$multi_channel) {
                // Meme traitement que multi date !
                $data['report_data'] = $this->reportRepository->get_shelf_multi_date_brand($date_type, $start_date, $end_date, $category_id, '-1', '-1');
                //dd($data['report_data']);
                $dates = array();
                $count_date = 0;
                $components_date = array();
                $components = array();
                $components_chart = array();

                foreach ($data['report_data'] as $row) {
                    $date = ($row['date']);
                    if (!in_array($date, $dates)) {
                        $dates[] = $date;
                        $count_date += 1;
                    }
                    $components[$row['brand_name']][$date] = array($row['shelf'], $row['metrage']);
                    $components_chart[$row['brand_name']][$date] = $row['metrage'];
                    $components_date [$row['date']] [$row['brand_name']] = $row['metrage'];
                }
                $sum_metrage_date = array();
                foreach ($components_date as $date => $componentBrand) {
                    $sum_metrage_date[$date] = array_sum(array_values($componentBrand));
                }

                //dd($components);
                $data['components'] = $components;
                $data['dates'] = $dates;
                $data['sum_metrage_date'] = $sum_metrage_date;
                $data['components_chart'] = $components_chart;
                $data['dates'] = $dates;
                $data['count_date'] = $count_date;
            } // Single Date + Multi Zones
            else if (!$multi_date && $multi_zone) {
                $data['report_data'] = $this->reportRepository->get_shelf_single_date_brand_zones($date_type, $start_date, $end_date, $category_id, $selected_zone_ids, $selected_channel_ids);
//                $data['sum_shelf'] = array_sum(array_values($this->reportRepository->get_total_shelf($date_type, $start_date, $end_date, $category_id, $selected_zone_ids, $selected_channel_ids)));
                $data['sum_metrage'] = array_sum(array_values($this->reportRepository->get_total_metrage($date_type, $start_date, $end_date, $category_id, $selected_zone_ids, $selected_channel_ids)));

                $zones = array();
                $components = array();
                $sum_shelf_zone = array();
                $components_zone = array();
                foreach ($data['report_data'] as $row) {
                    $zone = $row['zone'];
                    if (!in_array($zone, $zones)) {
                        $zones[] = $zone;
                    }
                    //create an array for every brand and the count at a outlet
                    $components[$row['brand_name']][$zone] = array($row['shelf'], $row['metrage'], $row['color']);
                    $components_zone [$row['zone']] [$row['brand_name']] = $row['metrage'];
                }// end foreach report_data

                foreach ($components_zone as $zone => $componentBrand) {
                    $sum_shelf_zone[$zone] = array_sum(array_values($componentBrand));
                }
                $data['components'] = $components;
                $data['components_zone'] = $components_zone;
                $data['sum_shelf_zone'] = $sum_shelf_zone;
                $data['zones'] = $zones;
            } // Single Date + Multi Channels
            else if (!$multi_date && !$multi_zone && $multi_channel) {
                $data['report_data'] = $this->reportRepository->get_shelf_single_date_brand_channels($date_type, $start_date, $end_date, $category_id, $selected_zone_ids, $selected_channel_ids);
                $data['sum_shelf'] = array_sum(array_values($this->reportRepository->get_total_shelf($date_type, $start_date, $end_date, $category_id, $selected_zone_ids, $selected_channel_ids)));

                $channels = array();
                $components = array();
                $components_channel = array();
                $sum_shelf_channel = array();
                //dd($data['report_data']);
                foreach ($data['report_data'] as $row) {
                    $channel = $row['channel'];
                    if (!in_array($channel, $channels)) {
                        $channels[] = $channel;
                    }
                    //create an array for every brand and the count at a outlet
                    $components[$row['brand_name']][$channel] = array($row['shelf'], $row['color']);
                    $components_channel [$row['channel']] [$row['brand_name']] = $row['shelf'];
                }// end foreach report_data

                foreach ($components_channel as $channel => $componentBrand) {
                    $sum_shelf_channel[$channel] = array_sum(array_values($componentBrand));
                }
                $data['components'] = $components;
                $data['components_channel'] = $components_channel;
                $data['channels'] = $channels;
                $data['sum_shelf_channel'] = $sum_shelf_channel;
            }
        }//end if ($start_date && $end_date)


        $data['multi_date'] = $multi_date;
        $data['multi_zone'] = $multi_zone;
        $data['multi_channel'] = $multi_channel;

        $data['date_type'] = $date_type;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['category_id'] = $category_id;


        return view('admin.report.shelf_share.form_report', $data);
    }

    function load_shelf_zone(Request $request)
    {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date_type = $request->input('date_type');
        $category_id = $request->input('category_id');
        $zone_id = $request->input('zone_id');

        $channel_ids = json_decode($request->input('json_channel_ids'));
        $data['channel_ids'] = $channel_ids;
        $data['json_channel_ids'] = $request->input('json_channel_ids');

        $data['zone_id'] = $zone_id;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['date_type'] = $date_type;
        $data['category_id'] = $category_id;

        $data['zone_val'] = $request->input('zone_val');
        $data['out_val'] = $request->input('out_val');

        if ($category_id != '-1' && $start_date && $end_date) {
            $data['clusters'] = $this->clusterRepository->get_clusters_by_category($category_id);
        }
        $data['report_data'] = $this->reportRepository->get_shelf_multi_date_brand($date_type, $start_date, $end_date, $category_id, $zone_id, $channel_ids);

        //dd($data['report_data']);
        $dates = array();
        $count_date = 0;
        $components = array();
        $components_date = array();
        //$components_chart = array();
        //$brand_colors = array();

        foreach ($data['report_data'] as $row) {

            $date = ($row['date']);
            if (!in_array($date, $dates)) {
                $dates[] = $date;
                $count_date += 1;
            }

            $components[$row['brand_name']][$date] = array($row['shelf']);
            $components_date [$row['date']] [$row['brand_name']] = $row['shelf'];
//            $components_chart[$row['brand_name']][$date] = $row['shelf'];
//            $brand_colors[$row['brand_name']] = $row['brand_color'];
        }
        $sum_shelf_date = array();
        foreach ($components_date as $date => $componentBrand) {
            $sum_shelf_date[$date] = array_sum(array_values($componentBrand));
        }
        $data['components'] = $components;
        $data['dates'] = $dates;
        $data['sum_shelf_date'] = $sum_shelf_date;
        return view('admin.report.shelf_share.multi_date.load_shelf_zone', $data);
    }

    function load_shelf_channel(Request $request)
    {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date_type = $request->input('date_type');
        $category_id = $request->input('category_id');
        $channel_id = $request->input('channel_id');
        $zone_id = $request->input('zone_id');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['date_type'] = $date_type;
        $data['category_id'] = $category_id;
        $data['channel_id'] = $channel_id;

        $data['out_val'] = $request->input('out_val');
        $data['channel_val'] = $request->input('channel_val');

        if ($category_id != '-1' && $start_date && $end_date) {
            $data['clusters'] = $this->clusterRepository->get_clusters_by_category($category_id);
        }

        $data['report_data'] = $this->reportRepository->get_shelf_multi_date_brand($date_type, $start_date, $end_date, $category_id, $zone_id, $channel_id);
        //dd($data['report_data']);
        $dates = array();
        $count_date = 0;
        $components = array();
        $components_date = array();
        //$components_chart = array();
        //$brand_colors = array();

        foreach ($data['report_data'] as $row) {

            $date = ($row['date']);
            if (!in_array($date, $dates)) {
                $dates[] = $date;
                $count_date += 1;
            }

            $components[$row['brand_name']][$date] = array($row['shelf']);
            $components_date [$row['date']] [$row['brand_name']] = $row['shelf'];
//            $components_chart[$row['brand_name']][$date] = $row['shelf'];
//            $brand_colors[$row['brand_name']] = $row['brand_color'];
        }
        $sum_shelf_date = array();
        foreach ($components_date as $date => $componentBrand) {
            $sum_shelf_date[$date] = array_sum(array_values($componentBrand));
        }
        $data['components'] = $components;
        $data['dates'] = $dates;
        $data['sum_shelf_date'] = $sum_shelf_date;
        return view('admin.report.shelf_share.multi_date.load_shelf_channel', $data);
    }

    //multi date
    //single date 
    //load shelf zone
    //load shelf channel
    function load_shelf_cluster(Request $request)
    {
        $date_type = $request->input('date_type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $cluster_id = $request->input('cluster_id');
        $category_id = $request->input('category_id');
        $data['cluster_id'] = $cluster_id;
        $data['category_id'] = $category_id;
        $data['date_type'] = $date_type;

        if (($request->input('json_channel_ids')))
            $channel_ids = json_decode($request->input('json_channel_ids'));
        else if (($request->input('channel_id')))
            $channel_ids = $request->input('channel_id');

        $zone_ids = $request->input('zone_id');

        $data['out_val'] = $request->input('out_val');
        $data['zone_val'] = $request->input('zone_val');
        $data['report_data'] = $this->reportRepository->get_shelf_cluster($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids);
        $data['sum_metrage'] = $this->reportRepository->get_total_metrage($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids);
//dd( $data['report_data']);
        return view('admin.report.shelf_share.load_shelf_cluster', $data);
    }

    function load_shelf_zone_pie_chart(Request $request)
    {
        $date_type = $request->input('date_type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $zone_id = $request->input('zone_id');
        $category_id = $request->input('category_id');
        $data['zone_id'] = $zone_id;
        $data['report_data'] = $this->reportRepository->get_shelf_zone_pie_chart($date_type, $start_date, $end_date, $category_id, $zone_id);
        return view('admin.report.shelf_share.single_date.load_shelf_zone_pie_chart', $data);
    }

    function load_shelf_channel_pie_chart(Request $request)
    {
        $date_type = $request->input('date_type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $channel_id = $request->input('channel_id');
        $category_id = $request->input('category_id');
        $data['channel_id'] = $channel_id;
        $data['report_data'] = $this->reportRepository->get_shelf_channel_pie_chart($date_type, $start_date, $end_date, $category_id, $channel_id);
        return view('admin.report.shelf_share.single_date.load_shelf_channel_pie_chart', $data);
    }

    function load_shelf_cluster_zones(Request $request)
    {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date_type = $request->input('date_type');
        $category_id = $request->input('category_id');
        $cluster_id = $request->input('cluster_id');

        $zone_ids = json_decode($request->input('json_zone_ids'));
        $channel_ids = json_decode($request->input('json_channel_ids'));

        $data['cluster_id'] = $cluster_id;
        $data['out_val'] = $request->input('out_val');
        $data['zone_val'] = $request->input('zone_val');

        $data['report_data'] = $this->reportRepository->get_shelf_cluster_zones($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids);
        $data['sum_shelf_array'] = $this->reportRepository->get_total_shelf_by_zone($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids);
        $data['sum_shelf'] = array_sum(array_values($data['sum_shelf_array']));
        return view('admin.report.shelf_share.single_date.load_shelf_cluster_zones', $data);
    }

    function load_shelf_cluster_channels(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date_type = $request->input('date_type');

        $category_id = $request->input('category_id');
        $cluster_id = $request->input('cluster_id');

        $zone_ids = json_decode(json_decode($request->input('json_zone_ids')));
        $channel_ids = json_decode($request->input('json_channel_ids'));

        $data['cluster_id'] = $cluster_id;
        $data['out_val'] = $request->input('out_val');
        $data['zone_val'] = $request->input('zone_val');

        $data['report_data'] = $this->reportRepository->get_shelf_cluster_channels($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids);
        $data['sum_shelf_array'] = $this->reportRepository->get_total_shelf_by_channels($date_type, $start_date, $end_date, $category_id);
        $data['sum_shelf'] = array_sum(array_values($data['sum_shelf_array']));
        return view('admin.report.shelf_share.single_date.load_shelf_cluster_channels', $data);
    }

    function extarait_pdv_shelf_share_report_old(Request $request)
    {

        $title = 'Report';
        $subTitle = 'POS Stock Issues';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $start_date = ($request->input("start_date")) ? $request->input("start_date") : "";
        $end_date = ($request->input("end_date")) ? $request->input("end_date") : "";


        $date_types['month'] = 'Monthly';
        $date_types['week'] = 'Weekly';
        $date_types['quarter'] = 'Quarter';
        $data['date_types'] = $date_types;


        $quarter_dates = array();
        $quarter_dates['01-01'] = 'Q1';
        $quarter_dates['04-01'] = 'Q2';
        $quarter_dates['07-01'] = 'Q3';
        $quarter_dates['10-01'] = 'Q4';
        $data['quarter_dates'] = $quarter_dates;

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        //$channels->prepend('All Channels', -1);
        $data['channels'] = $channels;

        //r�cup�rer le formulaire 

        $date_type = ($request->input("date_type")) ? $request->input("date_type") : "month";

        $channel_id = $request->input('channel_id');
        //dd($date_type);
        if ($date_type == 'month') {
            $start_date = $request->input('start_date_m');
            $end_date = $request->input('end_date_m');
            $data['subTitle'] = "POS Stock Issues Report | " . format_month($start_date) . ' --> ' . format_month($end_date);
        } else if ($date_type == 'week') {
            $start_date = $request->input('start_date_w');
            $end_date = $request->input('end_date_w');
            $data['subTitle'] = "POS Stock Issues Report | " . format_week($start_date) . ' --> ' . format_week($end_date);
        } else if ($date_type == 'quarter') {
            $year1 = $request->input('year1');
            $quarter1 = $request->input('quarter1');

            $year2 = $request->input('year2');
            $quarter2 = $request->input('quarter2');

            $start_date = $year1 . '-' . $quarter1;
            $end_date = $year2 . '-' . $quarter2;
        }

        $data['date_type'] = $date_type;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['channel_id'] = $channel_id;

        if ($start_date && $end_date) {
            //limit
            $row = 0;

            //offset
            $rowperpage = 1;

            $categories = $this->categoryRepository->getLimitCategories($rowperpage, $row);
            //dd($categories);
            $category_id = $categories->first()->id;
            $data['allcount'] = $this->categoryRepository->countCategories();

            $data['report_data'] = $this->reportRepository->get_extarait_pdv_shelf_share_per_category($date_type, $start_date, $end_date, $category_id, $channel_id);

            $outlets = array();
            $components = array();
            $components_outlet_name = array();
            $count_outlets = 0;
            foreach ($data['report_data'] as $row) {
                $outlet_name = ($row['outlet_name']);
                if (!in_array($outlet_name, $outlets)) {
                    $outlets[] = $outlet_name;
                    $count_outlets += 1;
                }
                //create an array for every brand and the count at a outlet
                $components[$row['product_id']][$outlet_name] = array($row['shelf'], $row['total']);
                $components_outlet_name [$row['outlet_name']] [$row['product_id']] = $row['shelf'];
            }// end foreach report_data

            $sum_shelf_outlet = array();

            foreach ($components_outlet_name as $outlet => $componentPr) {
                $sum_shelf_outlet[$outlet] = array_sum(array_values($componentPr));
            }


            $data['components'] = $components;
            $data['outlets'] = $outlets;
            $data['categories'] = $categories;
            $data['sum_shelf_outlet'] = $sum_shelf_outlet;
        }
        return view('admin.report.shelf_share.extarait_pdv_shelf_report', $data);
    }

    function extarait_pdv_shelf_share_report(Request $request)
    {

        $title = 'Report';
        $subTitle = 'POS Stock Issues';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $start_date = ($request->input("start_date")) ? $request->input("start_date") : "";
        $end_date = ($request->input("end_date")) ? $request->input("end_date") : "";


        $date_types['month'] = 'Monthly';
        $date_types['week'] = 'Weekly';
        $date_types['quarter'] = 'Quarter';
        $data['date_types'] = $date_types;


        $quarter_dates = array();
        $quarter_dates['01-01'] = 'Q1';
        $quarter_dates['04-01'] = 'Q2';
        $quarter_dates['07-01'] = 'Q3';
        $quarter_dates['10-01'] = 'Q4';
        $data['quarter_dates'] = $quarter_dates;

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        //$channels->prepend('All Channels', -1);
        $data['channels'] = $channels;

        //r�cup�rer le formulaire 

        $date_type = ($request->input("date_type")) ? $request->input("date_type") : "month";

        $channel_id = $request->input('channel_id');
        //dd($date_type);
        if ($date_type == 'month') {
            $start_date = $request->input('start_date_m');
            $end_date = $request->input('end_date_m');
            $data['subTitle'] = "POS Stock Issues Report | " . format_month($start_date) . ' --> ' . format_month($end_date);
        } else if ($date_type == 'week') {
            $start_date = $request->input('start_date_w');
            $end_date = $request->input('end_date_w');
            $data['subTitle'] = "POS Stock Issues Report | " . format_week($start_date) . ' --> ' . format_week($end_date);
        } else if ($date_type == 'quarter') {
            $year1 = $request->input('year1');
            $quarter1 = $request->input('quarter1');

            $year2 = $request->input('year2');
            $quarter2 = $request->input('quarter2');

            $start_date = $year1 . '-' . $quarter1;
            $end_date = $year2 . '-' . $quarter2;
        }

        $data['date_type'] = $date_type;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['channel_id'] = $channel_id;

        if ($start_date && $end_date) {
            //limit
            $row = 0;

            //offset
            $rowperpage = 1;

            $categories = $this->categoryRepository->getLimitCategories($rowperpage, $row);
            //dd($categories);
            $category_id = $categories->first()->id;
            $data['allcount'] = $this->categoryRepository->countCategories();

            $data['report_data'] = $this->reportRepository->get_extarait_pdv_shelf_share_per_category($date_type, $start_date, $end_date, $category_id, $channel_id);
            $data['sum_metrage'] = $this->reportRepository->get_total_metrage_by_outlets($date_type, $start_date, $end_date, $category_id, $channel_id);

            $outlets = array();
            $components = array();
            $count_outlets = 0;
            foreach ($data['report_data'] as $row) {
                $outlet_name = ($row['outlet_name']);
                if (!in_array($outlet_name, $outlets)) {
                    $outlets[] = $outlet_name;
                    $count_outlets += 1;
                }
                //create an array for every brand and the count at a outlet
                $components[$row['product_id']][$outlet_name] = array($row['shelf'], $row['metrage']);
            }// end foreach report_data

            $data['components'] = $components;
            $data['outlets'] = $outlets;
            $data['categories'] = $categories;
        }
        return view('admin.report.shelf_share.extarait_pdv_shelf_report', $data);
    }

    //AJAX CALL
    function load_extarait_pdv_shelf_share_per_category(Request $request)
    {

        $date_type = $request->input('date_type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $channel_id = $request->input('channel_id');
        //$category_id = $request->input('category_id');

        $row = $request->input('row');
        $rowperpage = 1;

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['date_type'] = $date_type;
        $data['channel_id'] = $channel_id;

        $categories = $this->categoryRepository->getLimitCategories($rowperpage, $row);
        $data['categories'] = $categories;
        $category_id = $categories->first()->id;
//        $data['category_id'] = $category_id;


        $data['report_data'] = $this->reportRepository->get_extarait_pdv_shelf_share_per_category($date_type, $start_date, $end_date, $category_id, $channel_id);
        $data['sum_metrage'] = $this->reportRepository->get_total_metrage_by_outlets($date_type, $start_date, $end_date, $category_id, $channel_id);

        $outlets = array();
        $components = array();
        $count_outlets = 0;
        foreach ($data['report_data'] as $row) {
            $outlet_name = ($row['outlet_name']);
            if (!in_array($outlet_name, $outlets)) {
                $outlets[] = $outlet_name;
                $count_outlets += 1;
            }
            //create an array for every brand and the count at a outlet
            $components[$row['product_id']][$outlet_name] = array($row['shelf'], $row['metrage']);
        }// end foreach report_data

        $data['components'] = $components;
        $data['outlets'] = $outlets;

        return view('admin.report.shelf_share.load_extarait_pdv_shelf_per_category', $data);
    }

    //////////////////////////////END SHELF SHARE REPORT /////////////////////////////////////////////////////
    public function branding(Request $request)
    {

        $title = 'Report';
        $subTitle = 'Branding';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->pluck('name', 'id');
        $fos->prepend('Please select', -1);

        $zones = $this->zoneRepository->listZones(['id', 'name']);
        $zones = $zones->pluck('name', 'id');
        $zones->prepend('Please select', -1);

        $outlets = $this->outletRepository->listOutlets(['id', 'name']);
        $outlets = $outlets->pluck('name', 'id');
        $outlets->prepend('Please select', -1);

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
            $branding_report = $this->reportRepository->get_branding_data($start_date, $end_date, $outlet_id, $fo_id, $zone_id);
//$branding_report = $branding_report->toArray();
//dd($data['branding_report']);
            $data['branding_report'] = $branding_report;
        }
        return view('admin.report.pictures.branding', $data);
    }

    public function store_album(Request $request)
    {

        $title = 'Report';
        $subTitle = 'Store Album';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->pluck('name', 'id');
        $fos->prepend('Please select', -1);

        $zones = $this->zoneRepository->listZones(['id', 'name']);
        $zones = $zones->pluck('name', 'id');
        $zones->prepend('Please select', -1);

        $outlets = $this->outletRepository->listOutlets(['id', 'name']);
        $outlets = $outlets->pluck('name', 'id');
        $outlets->prepend('Please select', -1);


        $fo_id = ($request->input("fo_id")) ? $request->input("fo_id") : "-1";
        $zone_id = ($request->input("zone_id")) ? $request->input("zone_id") : "-1";
        $outlet_id = ($request->input("outlet_id")) ? $request->input("outlet_id") : "-1";

        $data['outlets'] = $outlets;
        $data['fos'] = $fos;
        $data['zones'] = $zones;


        $data['zone_id'] = $zone_id;
        $data['fo_id'] = $fo_id;
        $data['outlet_id'] = $outlet_id;


        if ($fo_id != -1) {
            $store_album_report = $this->reportRepository->get_store_album_data($outlet_id, $fo_id, $zone_id);
//$store_album_report = $store_album_report->toArray();
//dd($data['store_album_report']);
            $data['store_album_report'] = $store_album_report;
        }
        return view('admin.report.pictures.store_album', $data);
    }

    public function price_monotoring(Request $request)
    {

        $title = 'Report';
        $subTitle = 'Price Monotoring';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $categories = $this->categoryRepository->listCategories(['id', 'name']);
        $categories = $categories->pluck('name', 'id');
//        $categories->prepend('All Categories', -1);

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        $channels->prepend('Please select', -1);

        $start_date = ($request->input("start_date_m")) ? $request->input("start_date_m") : "";
        $channel_id = ($request->input("channel_id")) ? $request->input("channel_id") : "-1";
        $category_id = ($request->input("category_id")) ? $request->input("category_id") : "-1";

        if ($category_id != '-1') {
            $data['clusters'] = $this->clusterRepository->get_clusters_by_category($category_id);
//dd($data['clusters']);
        }

        $data['channels'] = $channels;
        $data['categories'] = $categories;

        $data['start_date'] = $start_date;
        $data['channel_id'] = $channel_id;
        $data['category_id'] = $category_id;

        return view('admin.report.price_monotoring', $data);
    }

    public function load_price_monotoring_per_cluster(Request $request)
    {
        //dd($request);
        $data = array();
        $start_date = ($request->input("start_date")) ? $request->input("start_date") : "";
        $channel_id = ($request->input("channel_id")) ? $request->input("channel_id") : "-1";
        $category_id = ($request->input("category_id")) ? $request->input("category_id") : "-1";
        $cluster_id = ($request->input("cluster_id")) ? $request->input("cluster_id") : "-1";


        if ($start_date != '' && $cluster_id != -1) {
            $report_data = $this->reportRepository->get_price_monotoring_data($start_date, $channel_id, $category_id, $cluster_id);
            if (!empty($report_data->toArray())) {
                //dd($report_data);
                $outlets = array();
                $components = array();
                foreach ($report_data as $row) {
                    if (!in_array($row['outlet_name'], $outlets)) {
                        $outlets[] = $row['outlet_name'];
                    }
                    $components[$row['product_id']][$row['outlet_name']] = array($row['price'], $row['promo_price']);
                    $data['components'] = $components;
                    $data['outlets'] = $outlets;
                }
                return view('admin.report.load_price_monotoring_per_cluster', $data);
            }
        }
    }

    //NUMERIC DISTRIBUTION CARTOGRAPHIque
    public function dn_map(Request $request)
    {

        $title = 'Mapping';
        $subTitle = \Lang::get('project.DISTRIBUTION_NUMERIQUE');

        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $av_types = array();
        $av_types['2'] = 'AV';
        $av_types['1'] = 'OOS';
        $av_types['3'] = 'HA';
        $data['av_types'] = $av_types;

        $data_prod = $this->productRepository->getProductByBrand(1);

        $products = $data_prod->pluck('product_name', 'product_id');
        $products->prepend('All Products', 0);

        $product_groups = $data_prod->pluck('product_group_name', 'product_group_id');
        $product_groups->prepend('All Product Groups', 0);

        $clusters = $data_prod->pluck('cluster_name', 'cluster_id');
        $clusters->prepend('All Clusters', 0);

        $sub_categories = $data_prod->pluck('sub_category_name', 'sub_category_id');
        $sub_categories->prepend('All Sub Categories', 0);

        $categories = $data_prod->pluck('category_name', 'category_id');
        $categories->prepend('All Categories', 0);


        $channels = $this->channelRepository->listChannels();
        $data['channels_badge'] = $channels;
        $channels = $channels->pluck('name', 'id');
        $channels->prepend('All Channels', -1);

        $data['channels'] = $channels;
        $data['categories'] = $categories;
        $data['sub_categories'] = $sub_categories;
        $data['clusters'] = $clusters;
        $data['product_groups'] = $product_groups;
        $data['products'] = $products;


        $start_date = ($request->input('start_date')) ? $request->input("start_date") : "";
        $end_date = ($request->input('end_date')) ? $request->input("end_date") : "";
        $channel_id = ($request->input('channel_id')) ? $request->input("channel_id") : "-1";
//******************
        $category_id = ($request->input('category_id')) ? $request->input("category_id") : "0";
        $sub_category_id = ($request->input('sub_category_id')) ? $request->input("sub_category_id") : "0";
        $cluster_id = ($request->input('cluster_id')) ? $request->input("cluster_id") : "0";
        $product_group_id = ($request->input('product_group_id')) ? $request->input("product_group_id") : "0";
        $product_id = ($request->input('product_id')) ? $request->input("product_id") : "0";
//**********************

        $av_type = ($request->input('av_type')) ? $request->input('av_type') : "2";
//****************************
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['channel_id'] = $channel_id;
        $data['av_type'] = $av_type;

        $data['category_id'] = $category_id;
        $data['sub_category_id'] = $sub_category_id;
        $data['cluster_id'] = $cluster_id;
        $data['product_group_id'] = $product_group_id;
        $data['product_id'] = $product_id;
        //dd($data);
//*********************report************************************

        $outlets = array();
        if ($start_date != "" and $start_date != "") {
            $outlets = $this->reportRepository->get_data_for_outlet_numeric_distribution($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id);
            //dd($outlets);
            $data['outlets'] = $outlets;

            //map one
            $config['center'] = '35.0534864,9.2408933';
            $config['zoom'] = '6.9';
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
//            foreach ($outlets as $outlet) {
//                echo $outlet->av . '**********' . $outlet->id;
//                echo '<br>';
//                echo '<br>';
//            }
//            dd();
            foreach ($outlets as $outlet) {

//                if ($av_type == 1) {
//                    $av_type_name = 'oos';
//                    $av_data = number_format($outlet->oos, 2, '.', ' ');
//                } else if ($av_type == 2) {
//                    $av_type_name = 'av';
//                    $av_data = number_format($outlet->av, 2, '.', ' ');
//                } else {
//                    $av_type_name = 'NAN';
//                    $av_data = NAN;
//                }
                $marker = array();
                $content = '<b>Outlet name:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone_name
                    . '</br><b>Channel:</b> ' . $outlet->channel_name
                    . '</br><b>State:</b> ' . $outlet->state_name
                    . '</br><b>' . 'av' . ': </b>' . number_format($outlet->av, 2, '.', ' ') . '%'
                    . ' </br><b>Show outlet details:</b> <a class="m--font-red red filter-submit margin-bottom" href="' . url('admin/outlet/view/' . $outlet->id) . '  " data-toggle="tooltip" data-placement="top" title="Outlet details" target="_blank"><i class="fas fa-map-o"></i></a>';

                $marker['infowindow_content'] = $content;
                //UHD
                if ($outlet->channel_id == 1 && $outlet->active == 1 && $outlet->av != 0.0000) {
                    $marker['icon'] = url('assets/img/blue1.png');
                } //GEMO
                else if ($outlet->channel_id == 2 && $outlet->active == 1 && $outlet->av != 0.0000) {
                    $marker['icon'] = url('assets/img/red1.png');
                } //MG
                else if ($outlet->channel_id == 3 && $outlet->active == 1 && $outlet->av != 0.0000) {
                    $marker['icon'] = url('assets/img/green1.png');
                } //oos = 0
                else if ($outlet->active == 1 && $outlet->av == 0.0000) {
                    $marker['icon'] = url('assets/img/black1.png');
                }

//
//              if ($outlet->av == 0.0000) {
//                    $marker['icon'] = url('assets/img/black1.png');
//
//                }
                $marker['position'] = $outlet->latitude . ',' . $outlet->longitude;

                $this->gmap->add_marker($marker);

//                if ($av_type == 1 && ($outlet->oos > 0)) {
//                     $this->gmap->add_marker($marker);
//                } else if ($av_type == 2 && ($outlet->av > 0)) {
//                    $this->gmap->add_marker($marker);
//                }
            }
            $data['map_one'] = $this->gmap->create_map();

            //map two
            $outlets_for_map_two = $this->reportRepository->get_data_per_state_for_outlet_numeric_distribution($start_date, $end_date, $channel_id, $av_type, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id);
            $data['outlets_for_map_two'] = $outlets_for_map_two;
            //dd($outlets_for_map_two);
        }
        return view('admin.report.numeric_distribution.dn_maps', $data);
    }

    function get_data_for_dn_maps_report(Request $request)
    {

        $data = $request->input("data");
        $type = $request->input("type");

        $sub_categories[0] = 'All_sub_categories';
        $categories[0] = 'All_categories';
        $clusters[0] = 'All_clusters';
        $product_groups[0] = 'All_product_groups';
        $products[0] = 'All_products';

        foreach ($this->productRepository->get_data_for_dn_maps_report($data, $type) as $data) {

            $sub_categories[$data->sub_category_id] = $data->sub_category_name;
            $categories[$data->category_id] = $data->category_name;
            $clusters[$data->cluster_id] = $data->cluster_name;
            $product_groups[$data->product_group_id] = $data->product_group_name;
            $products[$data->product_id] = $data->product_name;
        }

        $response = array(
            'sub_categories' => $sub_categories,
            'categories' => $categories,
            'clusters' => $clusters,
            'product_groups' => $product_groups,
            'products' => $products,
        );
        echo json_encode($response);
    }


    function export_map($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $product_group_id, $product_id)
    {
        $outlets = $this->reportRepository->get_outlet_numeric_distribution($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $product_group_id, $product_id);
        $customer_array[] = array('Name', 'channel', 'sub_channel', 'state');
        foreach ($outlets as $outlet) {
            //   print_r($outlet); echo '<br>';
            $total = $outlet->av + $outlet->oos;
            if ($total != 0) {
                $oos_data = number_format(($outlet->oos / ($total)) * 100, 2, '.', ' ');
                if ($oos_data != 0) {
                    $customer_array[] = array(
                        'Name'  => $outlet->name,
                        'channel'   => $outlet->channel,
                        'sub_channel'    => $outlet->sub_channel,
                        'state'  => $outlet->state,
                    );
                }
            }
        }
        Excel::create('Outlets', function($excel) use ($customer_array){
            $excel->setTitle('Outlets');
            $excel->sheet('Outlets', function($sheet) use ($customer_array){
                $sheet->fromArray($customer_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }


    //SHELF SHARE CARTOGHRAPHIE
    function shelf_map(Request $request)
    {


        $title = 'Mapping';
        $subTitle = 'SHELF SHARE';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;


        $data_prod = $this->productRepository->getProductByBrand(env('brand_id'));

        $products = $data_prod->pluck('product_name', 'product_id');
        $products->prepend('All Products', 0);

        $product_groups = $data_prod->pluck('product_group_name', 'product_group_id');
        $product_groups->prepend('All Product Groups', 0);

        $clusters = $data_prod->pluck('cluster_name', 'cluster_id');
        $clusters->prepend('All Clusters', 0);

        $sub_categories = $data_prod->pluck('sub_category_name', 'sub_category_id');
        $sub_categories->prepend('All Sub Categories', 0);

        $categories = $data_prod->pluck('category_name', 'category_id');
        $categories->prepend('All Categories', 0);


        $channels = $this->channelRepository->listChannels();
        $data['channels_badge'] = $channels;
        $channels = $channels->pluck('name', 'id');
        $channels->prepend('All Channels', -1);

        $data['channels'] = $channels;
        $data['categories'] = $categories;
        $data['sub_categories'] = $sub_categories;
        $data['clusters'] = $clusters;
        $data['product_groups'] = $product_groups;
        $data['products'] = $products;


        $start_date = ($request->input('start_date')) ? $request->input("start_date") : "";
        $end_date = ($request->input('end_date')) ? $request->input("end_date") : "";
        $channel_id = ($request->input('channel_id')) ? $request->input("channel_id") : "-1";
//******************
        $category_id = ($request->input('category_id')) ? $request->input("category_id") : "0";
        $sub_category_id = ($request->input('sub_category_id')) ? $request->input("sub_category_id") : "0";
        $cluster_id = ($request->input('cluster_id')) ? $request->input("cluster_id") : "0";
        $product_group_id = ($request->input('product_group_id')) ? $request->input("product_group_id") : "0";
        $product_id = ($request->input('product_id')) ? $request->input("product_id") : "0";
//**********************
//****************************
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['channel_id'] = $channel_id;


        $data['category_id'] = $category_id;
        $data['sub_category_id'] = $sub_category_id;
        $data['cluster_id'] = $cluster_id;
        $data['product_group_id'] = $product_group_id;
        $data['product_id'] = $product_id;
        //dd($data);
//*********************report************************************

        $outlets = array();
        if ($start_date != "" and $start_date != "") {
            $outlets = $this->reportRepository->get_data_for_outlet_shelf_share($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id);
            //dd($outlets);
            $data['outlets'] = $outlets;

            //map one
            $config['center'] = '35.0534864,9.2408933';
            $config['zoom'] = '6.9';
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

            foreach ($outlets as $outlet) {

//                $av_type_name = 'shelf';
//                $shelf = $outlet->shelf;
//                $shelf_perc = number_format($outlet->shelf_perc, 2, '.', ' ');


                $marker = array();
                $content = '<b>Outlet name:</b> ' . $outlet->name
                    . '</br><b>Zone:</b> ' . $outlet->zone_name
                    . '</br><b>Channel:</b> ' . $outlet->channel_name
                    . '</br><b>State:</b> ' . $outlet->state_name
                    . '</br><b>nombre de facing for henkel: </b>' . $outlet->shelf_henkel . '(' . number_format($outlet->metrage_henkel * 100, 2, ',', ' ') . ')'
                    . '</br><b>all facing: </b>' . $outlet->all_shelf . '(' . number_format($outlet->all_metrage * 100, 2, ',', ' ') . ')'
                    . '</br><b>shelf %: </b>' . number_format($outlet->shelf_perc * 100, 2, ',', ' ') . '(' . number_format($outlet->metrage_perc * 100, 2, ',', ' ') . ')'
                    . ' </br><b>Show outlet details:</b> <a class="m--font-red red filter-submit margin-bottom" href="' . url('admin/outlet/view/' . $outlet->id) . '  " data-toggle="tooltip" data-placement="top" title="Outlet details" target="_blank"><i class="fas fa-map-o"></i></a>';
//                        . '<a class="btn btn-xs red filter-submit margin-bottom" href="' . site_url('outlets/view/' . $outlet->id) . ' " data-toggle="tooltip" data-placement="top" title="More details" target="_blank"><i class="icon-map"></i></a>';

                $marker['infowindow_content'] = $content;
                //UHD
                if ($outlet->channel_id == 1 && $outlet->active == 1) {
                    $marker['icon'] = url('assets/img/blue1.png');
                } //Gemo
                else if (($outlet->channel_id == 2 || $outlet->channel_id == 6) && $outlet->active == 1) {
                    $marker['icon'] = url('assets/img/red1.png');
                } //MG
                else if ($outlet->channel_id == 3 && $outlet->active == 1) {
                    $marker['icon'] = url('assets/img/green1.png');
                } //oos = 0
                else if ($outlet->active == 1 && $outlet->av == 0.0000) {
                    $marker['icon'] = url('assets/img/black1.png');
                }


                $marker['position'] = $outlet->latitude . ',' . $outlet->longitude;
                $this->gmap->add_marker($marker);
            }
            $data['map_one'] = $this->gmap->create_map();

            //map two
            $outlets_for_map_two = $this->reportRepository->get_data_per_state_for_outlet_shelf_share($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id);
            $data['outlets_for_map_two'] = $outlets_for_map_two;
            //dd($outlets_for_map_two);
        }
        return view('admin.report.shelf_share.shelf_share_maps', $data);
    }

    function get_data_for_shelf_maps_report(Request $request)
    {

        $data = $request->input("data");
        $type = $request->input("type");

        $sub_categories[0] = 'All_sub_categories';
        $categories[0] = 'All_categories';
        $clusters[0] = 'All_clusters';
        $product_groups[0] = 'All_product_groups';
        $products[0] = 'All_products';

        foreach ($this->productGroupRepository->get_data_for_shelf_maps_report($data, $type) as $data) {

            $sub_categories[$data->sub_category_id] = $data->sub_category_name;
            $categories[$data->category_id] = $data->category_name;
            $clusters[$data->cluster_id] = $data->cluster_name;
            $product_groups[$data->product_group_id] = $data->product_group_name;
            $products[$data->product_id] = $data->product_name;
        }

        $response = array(
            'sub_categories' => $sub_categories,
            'categories' => $categories,
            'clusters' => $clusters,
            'product_groups' => $product_groups,
            'products' => $products,
        );
        echo json_encode($response);
    }

    function stock_issue()
    {
        $title = 'Reports';
        $subTitle = 'TRACKING OOS';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;
        $data['report_data'] = $this->reportRepository->get_oos_tracking();
        //dd('in controller', $data['report_data']->toArray());
        return view('admin.report.stock_issue', $data);
    }

}
