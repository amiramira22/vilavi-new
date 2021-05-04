<?php

//beemerch

namespace App\Repositories;

use App\Entities\MyModel;
use App\Entities\Visit;
use App\Entities\Channel;
use App\Entities\Outlet;
use DB;
use DateTime;

class DashboardRepository
{

    public function __construct()
    {

    }

    function get_monthly_remarks_visits()
    {

        $query = Visit::select('visits.date as visit_date'
            , 'admin.name as fo_name'
            , 'admin.photos as fo_photo'
            , 'visits.remark as remark'
            , 'outlets.name as outlet_name')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('admin', 'visits.admin_id', '=', 'admin.id')
            ->where('visits.remark', '!=', '')
            ->where('visits.m_date', '=', date('Y-m-01'))
            ->orderBy('visits.id', 'desc');
        return $query->get();
    }

    function get_today_visits()
    {

        $query = Visit::select('visits.id as visit_id'
            , 'outlets.name as outlet_name'
            , 'outlets.id as outlet_id'
            , 'outlets.*'
            , 'channels.name as channel_name'
            , 'channels.id as channel_id'
            , 'sub_channels.name as sub_channel_name'
            , 'zones.name as zone_name'
            , 'states.name as state_name'
            , 'admin.name as fo_name')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('admin', 'visits.admin_id', '=', 'admin.id')
            ->join('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
            ->join('channels', 'sub_channels.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->where('visits.date', '=', date('Y-m-d'));
        return $query->get();
    }

    function get_oos_per_channel($brand_id, $m_date)
    {

        $query = MyModel::select('channels.name as channel', 'channels.color as color'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(count(bcc_models.id)))*100 as oos_old')
            ,DB::raw('count(bcc_models.id) as total'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)) as av'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)) as oos'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('admin', 'visits.admin_id', '=', 'admin.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.m_date', $m_date)
            ->where('brands.id', $brand_id)
            ->groupBy('channels.id')
            ->orderBy('oos', 'desc')
            ->get();
//        dd($query);

        $data = array();
        foreach ($query as $row) {
            $row_data = array();
            $row_data['name'] = str_replace(' ', '', $row['channel']);
//            $row_data['channel'] = html_entity_decode($row_data['channel']);
            //$row_data['y'] = (double)number_format($row['oos'], 2);
            $row_data['y'] = (double)number_format(($row['oos']/($row['oos']+$row['av']))*100, 2);
            $row_data['drilldown'] = str_replace(' ', '', $row['channel']);
            $row_data['color'] = '#ec0928 ';

            $data[] = $row_data;
        }//end for
        //dd(json_encode(array_reverse($data)));
        return json_encode($data);
    }

    //verifi�
    function get_oos_per_category($brand_id, $m_date)
    {
        $query = MyModel::select('categories.name as category_name'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(count(bcc_models.id)))*100 as oos_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(count(bcc_models.id)))*100 as av_old')
            ,DB::raw('count(bcc_models.id) as total'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)) as av'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)) as oos'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('brands.selected', 1)
            ->where('visits.m_date', $m_date)
            ->where('brands.id', $brand_id)
            ->groupBy('categories.id')
            ->orderBy('av', 'DESC')
            ->get();
        //dd($query);
        //return $query->get();

        $data = array();
        foreach ($query as $row) {
            $row_data = array();
            $row_data['category'] = str_replace(' ', '', $row['category_name']);
            $row_data['full'] = 100;
            //$row_data['av'] = (number_format($row['av'], 2) + 0);
            $row_data['av'] = (number_format(($row['av']/($row['oos']+$row['av']))*100, 2, '.', '')+ 0);
            $row_data['oos'] = (number_format(($row['oos']/($row['oos']+$row['av']))*100, 2, '.', '')+ 0);
            //$row_data['oos'] = (100 - number_format($row['av'], 2));
            $row_data['color'] = $row['color'];

            $data[] = $row_data;
        }//end for
        //dd(json_encode(array_reverse($data)));
        return json_encode($data);
    }

    //verifié
    function get_data_numeric_distribution($brand_id, $m_date)
    {

        //, DB::raw('((sum(CASE WHEN bcc_models.av_sku = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as av'), DB::raw('((sum(CASE WHEN bcc_models.av_sku = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos'), DB::raw('((sum(CASE WHEN bcc_models.av_sku = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as ha'), DB::raw('COUNT(bcc_models.id) as total'),

        $query = MyModel::select('brands.name as brand_name'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(count(bcc_models.id)))*100 as av_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(count(bcc_models.id)))*100 as oos_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/(count(bcc_models.id)))*100 as ha_old')
            , DB::raw('COUNT(bcc_models.id) as total'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)) as av'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)) as oos'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.m_date', $m_date)
            ->where('brands.id', $brand_id)
            ->groupBy('brands.id')
            ->get();

        $data = array();
        foreach ($query as $row) {

            $row_data = array();

            $row_data['brand_name'] = $row['brand_name'];
            //$row_data['oos'] = number_format($row['oos'], 2, '.', '');
            //$row_data['av'] = number_format($row['av'], 2, '.', '');
            $row_data['av'] = number_format(($row['av']/($row['oos']+$row['av']))*100, 2, '.', '');
            $row_data['oos'] = number_format(($row['oos']/($row['oos']+$row['av']))*100, 2, '.', '');

//            $row_data['ha'] = number_format($row['ha'], 2, '.', '');

            $row_data3['title'] = "AV";
            $row_data3['color'] = "#08AF02";
            $row_data3['value'] = number_format($row['av'], 2, '.', '');

            $row_data2['title'] = "OOS";
            $row_data2['color'] = "#FF0000";
            $row_data2['value'] = number_format($row['oos'], 2, '.', '');

//            $row_data4['title'] = "HA";
//            $row_data4['color'] = "#32a0d1";
//            $row_data4['value'] = number_format($row['ha'], 2, '.', '');


            $data[] = $row_data2;
            $data[] = $row_data3;
//            $data[] = $row_data4;
        }
        return json_encode(array_reverse($data));
    }

    // just 5 produits verifié
    function get_top_products_by_date($w_date, $all = 0)
    {

        $query = MyModel::select('products.name as product_name'
            , 'visits.w_date as w_date'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(count(bcc_models.id)))*100 as oos'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('visits.w_date', $w_date)
            ->where('brands.id',1)
            ->where('models.av','!=', 2)
            ->groupBy('products.id')
            ->orderBy('oos', 'desc');
        if ($all == 0)
            $query->limit(5);

        return $query->get();
    }

    //verifi�
    function get_data_oos_of_trend($category_id)
    {

        $current_date_time = new DateTime();
        //semaine courante
        $first_day_week_std = firstDayOf('week', $current_date_time);
        //8 semaine d'aprés 
        $first_day_two_last_8week_std = date('Y-m-d', strtotime("-56 day", strtotime("$first_day_week_std")));


        $query = MyModel::select('visits.w_date as date'
            , 'channels.name as channel_name'
            , 'channels.color as channel_color'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(count(bcc_models.id)))*100 as oos_old')
            , DB::raw('COUNT(bcc_models.id) as total'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)) as av'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)) as oos'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('channels.active', 1)
            ->where('visits.w_date', '>=', $first_day_two_last_8week_std)
            ->where('visits.w_date', '<=', $first_day_week_std)
            ->where('categories.id', $category_id)
            ->groupBy('visits.w_date')
            ->groupBy('channels.id')
            ->orderBy('visits.w_date', 'asc')
            ->get();
        //dd($query);
        $dates = array();
        $components = array();
        foreach ($query as $row) {
            $date = $row['date'];
            if (!in_array($date, $dates)) {
                $dates[] = $date;
            }
			if(($row['oos']+$row['av'])!=0)

            $oos = number_format(($row['oos']/($row['oos']+$row['av']))*100, 2, '.', '');
			else
$oos=0;
            //create an array for every brand and the count at a outlet
            $components[$row['channel_name']][$date] = array($oos, $row['channel_color']);

        }
        //die($dates);
        $data['components'] = $components;
        $data['dates'] = $dates;
        return $data;
    }

    function get_outlet_by_state_classe_details()
    {
        $channel_ids = Channel::select('channels.id as channel_id', 'channels.name as channel_name')
            ->distinct()
            ->get();

        $outlets = Outlet:: select('outlets.id as outlet_id', 'states.name as state_name','zones.name as zone_name')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->where('outlets.active', '=', 1)
            ->groupBy('states.id')
            ->orderBy('zones.id', 'ASC');


        foreach ($channel_ids as $row) {
            $outlets->addSelect(DB::raw("sum(CASE WHEN bcc_outlets.channel_id = " . $row->channel_id . " THEN bcc_outlets.active ELSE 0 END) as '" . $row->channel_name . "'"));
        }
        //dd($outlets->get());
        return $outlets->get();
    }

    function get_outlets_by_states()
    {
        $outlets = Outlet:: select('states.name as state_name', DB::raw('count(bcc_outlets.id) as count_outlet'))
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->where('outlets.active', '=', 1)
            ->groupBy('states.id');

        return $outlets->get();
    }

    function get_outlets_by_channels()
    {
        $outlets = Outlet:: select('outlets.channel as channel_name'
            , DB::raw('count(bcc_outlets.id) as count_outlet')
            , 'channels.color as channel_color')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->where('outlets.active', '=', 1)
            ->groupBy('channel_name');

        return $outlets->get();
    }

    function get_monthly_visit($month)
    {
        $query = Visit::select(DB::raw('count(bcc_visits.id) as nb_visits'), 'admin.name as fo_name', 'admin.id as fo_id')
            ->join('admin', 'visits.admin_id', '=', 'admin.id')
            ->where('admin.access', '=', 'Field Officer')
            ->where('visits.m_date', '=', $month)
            ->groupBy('admin.id')
            ->get()
            ->toArray();
        //dd($query);
        $new_tab = array();
        foreach ($query as $v) {

            $v['target'] = count_target_monthly_visits($v['fo_id'], $month);
            $new_tab[] = $v;
            //dd($v);
        }
        //dd($new_tab);
        return $new_tab;
    }

    function get_daily_visit($start_date, $end_date, $group_by)
    {

        $query = Visit::select(DB::raw('count(bcc_visits.id) as nb_visits'))
            ->where('visits.date', '>=', '' . $start_date . '')
            ->where('visits.date', '<=', '' . $end_date . '');

        if ($group_by === 'channels.id') {
            $query->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
                ->join('channels', 'outlets.channel_id', '=', 'channels.id')
                ->where('channels.active', '=', 1)
                ->addSelect('channels.name as group_by_name');
        } //
        else if ($group_by === 'admin.id') {
            $query->join('admin', 'visits.admin_id', '=', 'admin.id')
                ->where('admin.access', '=', 'Field Officer')
                ->addSelect('admin.name as group_by_name');
        }

        return $query->groupBy($group_by)->get()->toArray();
    }


    function get_daily_visit_details($start_date, $end_date, $group_by) {

        $finish_result = array();
        $start_date_traitement = $start_date;

        while (strtotime($start_date_traitement) <= strtotime($end_date)) {
            $today_letter = date('l', strtotime($start_date_traitement));
            $result = Outlet::select(DB::raw("sum(CASE WHEN bcc_outlets.visit_day like " . "'%" . $today_letter . "%'" . " THEN 1 ELSE 0 END) as target"))
                ->where('outlets.active', '=', 1);

            if ($group_by === 'channels.id') {
                $result->join('channels', 'outlets.channel_id', '=', 'channels.id')
                    ->where('channels.active', '=', 1)
                    ->addSelect('channels.name as group_by_name');
            }
            //
            else if ($group_by === 'admin.id') {
                $result->join('admin', 'outlets.admin_id', '=', 'admin.id')
                    ->where('admin.access', '=', 'Field Officer')
                    ->addSelect('admin.name as group_by_name');
            }
            $result = $result->groupBy($group_by)
                ->get()->toArray();

            $finish_result[] = $result;
            $start_date_traitement = date('Y-m-d', strtotime($start_date_traitement . '+ 1 days'));
        }


        $naw_tab = array();
        foreach ($finish_result as $row) {
            foreach ($row as $obj) {
                if (!isset($naw_tab[$obj['group_by_name']])) {
                    $naw_tab[$obj['group_by_name']] = new \stdClass();
                    $naw_tab[$obj['group_by_name']]->target = 0;
                    $naw_tab[$obj['group_by_name']]->target = $naw_tab[$obj['group_by_name']]->target + $obj['target'];
                } else {
                    $naw_tab[$obj['group_by_name']]->target = $naw_tab[$obj['group_by_name']]->target + $obj['target'];
                }
            }
        }


        $daily = $this->get_daily_visit($start_date, $end_date, $group_by);
        //dd($daily);
        foreach ($daily as $row_d) {
            //$naw_tab[$row_d['group_by_name']]->daily = 0;
            if (!isset($naw_tab[$row_d['group_by_name']])) {
                $naw_tab[$row_d['group_by_name']] = new \stdClass();
                $naw_tab[$row_d['group_by_name']]->target = 0;
                $naw_tab[$row_d['group_by_name']]->daily = 0;
            }

            $naw_tab[$row_d['group_by_name']]->daily = $row_d['nb_visits'];
        }

        //dd($result, $finish_result,$naw_tab);
        return($naw_tab);
    }


}
