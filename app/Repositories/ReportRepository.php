<?php

namespace App\Repositories;

use App\Entities\FoPerformance;
use App\Entities\MyModel;
use App\Entities\Visit;
use DB;

class ReportRepository extends ResourceRepository
{

    public function __construct()
    {

    }


    public function get_av_multi_date_brand($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {

        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('visits.' . $date . ' as date', 'brands.name as brand_name', 'brands.color as brand_color'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as av')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as oos')

            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as av_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as ha'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('brands.id', env('brand_id'))
//                ->where('brands.selected','=', 1)
            ->groupBy('visits.' . $date)
            ->groupBy('brands.id')
            ->orderBy('visits.' . $date, 'asc')
            ->orderBy('brands.code', 'asc');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }

        return $query->get();
    }

    public function get_av_single_date_brand_zones($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('zones.name as zone', 'brands.name as brand_name'
            , 'brands.color as brand_color'
            , 'brands.id as brand_id'

            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as av')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as oos')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as av_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as ha'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->where('brands.id', env('brand_id'))->where('brands.id', env('brand_id'))
//                ->where('brands.selected','=', 1)
            ->groupBy('zones.id')
            ->groupBy('brands.id');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
//
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
            $query->orderBy('zones.code', 'asc');
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
            $query->orderBy('zones.code', 'asc');
        }


        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }
        return $query->get();
    }

    public function get_av_single_date_brand_channels($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('channels.name as channel'
            , 'brands.name as brand_name'
            , 'brands.id as brand_id'
            , 'brands.color as brand_color'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as av')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as oos')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as av_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos_old'),
            DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as ha'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)->where('brands.id', env('brand_id'))
//                ->where('brands.selected','=', 1)
            //->where('brands.id','=', env('brand_id'))
            ->groupBy('channels.id')
            ->groupBy('brands.id');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (!empty($zone_ids) && $zone_ids != '-1') {
            $query->whereIn('zones.id', $zone_ids);
            $query->orderBy('zones.code', 'asc');
        }
        if (!empty($channel_ids) && $channel_ids != '-1') {
            $query->whereIn('channels.id', $channel_ids);
            $query->orderBy('channels.code', 'asc');
        }
        return $query->get();
    }

    public function get_av_cluster($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_id, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('visits.' . $date . ' as date', 'products.id as product_id'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as av')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as oos')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as av_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos_old'),
            DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as ha'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('clusters.id', '=', $cluster_id)
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)->where('brands.id', env('brand_id'))
//                ->where('brands.selected','=', 1)
            ->groupBy('visits.' . $date)
            ->groupBy('products.id')
            ->orderBy('visits.' . $date, 'asc')
            ->orderBy('brands.id', 'asc');


        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if ($zone_id != '-1') {
            $query->where('zones.id', '=', $zone_id);
            $query->orderBy('zones.code', 'asc');
        }

        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }
        return $query->get();
    }

    public function get_av_cluster_zones($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }

        $query = MyModel::select('zones.name as zone', 'products.id as product_id'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as av')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as oos')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as av_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos_old'),
            DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as ha'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)->where('brands.id', env('brand_id'))
            ->where('clusters.id', '=', $cluster_id)
//                ->where('brands.selected','=', 1)
            ->groupBy('zones.id')
            ->groupBy('products.id')
            ->orderBy('visits.' . $date, 'asc')
            ->orderBy('brands.id', 'asc');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (!empty($zone_ids) && $zone_ids != '-1') {
            $query->whereIn('zones.id', $zone_ids);
            $query->orderBy('zones.code', 'asc');
        }
        if (!empty($channel_ids) && $channel_ids != '-1') {
            $query->whereIn('channels.id', $channel_ids);
            $query->orderBy('channels.code', 'asc');
        }
        return $query->get();
    }

    public function get_av_cluster_channels($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }

        $query = MyModel::select('channels.name as channel', 'products.id as product_id'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as av')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as oos')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as av_old')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos_old'),
            DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as ha'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)->where('brands.id', env('brand_id'))
            ->where('clusters.id', '=', $cluster_id)
//                ->where('brands.selected','=', 1)
            ->groupBy('channels.id')
            ->groupBy('products.id')
            ->orderBy('visits.' . $date, 'asc')
            ->orderBy('brands.id', 'asc');


        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (!empty($zone_ids) && $zone_ids != '-1') {
            $query->whereIn('zones.id', $zone_ids);
            $query->orderBy('zones.code', 'asc');
        }
        if (!empty($channel_ids) && $channel_ids != '-1') {
            $query->whereIn('channels.id', $channel_ids);
            $query->orderBy('channels.code', 'asc');
        }
        return $query->get();
    }

    function get_extarait_pdv_dn_per_category($date_type, $start_date, $end_date, $category_id, $channel_id)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else {
            $date = 'w_date';
        }
        $query = MyModel::select('products.id as product_id',
            'outlets.name as outlet_name',
            'products.id as product_id',
            'outlets.id as outlet_id',
            'outlets.name as outlet_name',
            DB::raw('count(bcc_models.id) as total'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)) as av'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)) as oos'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END)) as ha')
        //DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos')
        )
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)->where('brands.id', env('brand_id'))
//                ->where('brands.selected','=', 1)
            ->groupBy('outlets.id')
            ->groupBy('products.id')
            ->orderBy('products.code', 'asc')
            ->orderBy('brands.id', 'asc')
            ->orderBy('outlets.name', 'asc');

        if ($channel_id && $channel_id != '-1') {
            $query->where('channels.id', '=', $channel_id);
        }

        if ($category_id && $category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        return $query->get();

    }

// Shelf share grouped by Brands and Dates (Multi Dates) --- Amira 29/01/2018
    public function get_shelf_multi_date_brand($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {

        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('visits.' . $date . ' as date'
            , 'brands.name as brand_name'
            , 'brands.color as brand_color'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('sum(bcc_models.y) as ny')
            // niveau des yeux -10 cad 0
            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied')
        )
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->where('channels.active', 1)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('visits.' . $date)
            ->groupBy('brands.id')
            ->orderBy('visits.' . $date, 'asc')
            ->orderBy('shelf', 'DESC');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }
        return $query->get();
    }

    // Shelf share for each cluster : grouped by Brands and Dates (Multi date)  --- Amira 29/01/2018
    public function get_shelf_cluster($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }

        $query = MyModel::select('visits.' . $date . ' as date'
            , 'product_groups.id as product_id'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')

            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied')
        )
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->where('channels.active', 1)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->where('clusters.id', $cluster_id)
//                ->where('brands.selected','=', 1)
            ->groupBy('product_groups.id')
            ->groupBy('visits.' . $date)
            ->orderBy('visits.' . $date, 'asc')
            ->orderBy('shelf', 'DESC');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }


        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }


        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }
        return $query->get();
    }

    public function get_total_metrage($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        $results = array();
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('visits.' . $date . ' as date'
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')

        )
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('visits.' . $date)
            ->orderBy('visits.' . $date, 'asc');


        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }
        $results = $query->get();
        $sum_metrage_array = array();
        foreach ($results as $row) {
            $sum_metrage_array[$row->date] = $row->metrage;
        }

        return $sum_metrage_array;
    }


    public function get_total_shelf($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        $results = array();
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('visits.' . $date . ' as date'
            , DB::raw('sum(bcc_models.shelf) as shelf')
        )
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('visits.' . $date)
            ->orderBy('visits.' . $date, 'asc');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }
        $results = $query->get();
        $sum_shelf_array = array();
        foreach ($results as $row) {
            $sum_shelf_array[$row->date] = $row->shelf;
        }

        return $sum_shelf_array;
    }


    public function get_total_shelf_NV($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        $results = array();
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('visits.' . $date . ' as date'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied')
        )
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('visits.' . $date)
            ->orderBy('visits.' . $date, 'asc');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }
        $results = $query->get();
        $sum_shelf_array = array();

        foreach ($results as $row) {
            $sum_shelf_array[$row->date] = $row->shelf;
            $sum_chapeau_array[$row->date] = $row->chapeau;
            $sum_yeux_array[$row->date] = $row->yeux;
            $sum_main_array[$row->date] = $row->main;
            $sum_pied_array[$row->date] = $row->pied;
        }

        $result_sum = array();
        $result_sum[] = $sum_shelf_array;
        $result_sum[] = $sum_chapeau_array;
        $result_sum[] = $sum_yeux_array;
        $result_sum[] = $sum_main_array;
        $result_sum[] = $sum_pied_array;
        //dd($result_sum);
        return $result_sum;

    }


// Availibility grouped by Brands and Zones (Single date) --- Boulbaba 27/01/2018
    public function get_shelf_single_date_brand_zones($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('zones.name as zone'
            , 'brands.name as brand_name'
            , 'brands.color as color'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('sum(bcc_models.y) as ny')
            // niveau des yeux -10 cad 0
            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied')
        )
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            //->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->where('channels.active', 1)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('zones.id')
            ->groupBy('brands.id')
            ->orderBy('shelf', 'DESC');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }
        return $query->get();
    }

// Shelf share grouped by Brands and Dates (Multi Dates) --- Amira 29/01/2018
    public function get_shelf_zone_pie_chart($date_type, $start_date, $end_date, $category_id, $zone_id)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }

        $query = MyModel::select('brands.name as brand_name'
            , 'brands.color as brand_color'
            , DB::raw('sum(bcc_models.shelf) as shelf'),
            DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'models.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('brands.id')
            ->orderBy('visits.' . $date, 'desc')
            ->orderBy('shelf', 'DESC');
        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if ($zone_id != -1 && !is_null($zone_id)) {
            $query->where('zones.id', '=', $zone_id);
        }

        //$total = array_sum(array_values($this->get_total_shelf($date_type, $start_date, $end_date, $category_id, $zone_id, -1)));
        $query = $query->get();
        $row_data = array();
        $data = array();
        foreach ($query as $row) {
            $row_data['brand_name'] = $row->brand_name;
            $row_data['brand_color'] = $row->brand_color;
            $row_data['shelf'] = ($row->shelf);
            $data[] = $row_data;
        }
//print_r($data);
        return json_encode($data);
    }

// Shelf share grouped by Brands and Dates (Multi Dates) --- Amira 29/01/2018
    public function get_shelf_channel_pie_chart($date_type, $start_date, $end_date, $category_id, $channel_id)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('brands.name as brand_name'
            , 'brands.color as brand_color'
            , DB::raw('sum(bcc_models.shelf) as shelf'),
            DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'models.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('brands.id')
            ->orderBy('visits.' . $date, 'desc')
            ->orderBy('shelf', 'DESC');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if ($channel_id != -1 && !is_null($channel_id)) {
            $query->where('channels.id', '=', $channel_id);
        }

        //$total = array_sum(array_values($this->get_total_shelf($date_type, $start_date, $end_date, $category_id, $zone_id, -1)));
        $query = $query->get();
        $row_data = array();
        $data = array();
        foreach ($query as $row) {
            $row_data['brand_name'] = $row->brand_name;
            $row_data['brand_color'] = $row->brand_color;
            $row_data['shelf'] = $row->shelf;
            $data[] = $row_data;
        }
        //print_r($data);
        return json_encode($data);
    }

// Availibility for each cluster : grouped by Brands and Zones (Single date)  --- Boulbaba 27/01/2018
    public function get_shelf_cluster_zones($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('zones.name as zone'
            , 'product_groups.id as product_group_id'
            , 'brands.name as brand_name'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied')
        )
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'models.product_group_id', '=', 'product_groups.id')
            //->join('products', 'products.product_group_id', '=', 'product_groups.id')

            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('clusters.id', $cluster_id)
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('zones.id')
            //->groupBy('products.id')
            ->groupBy('product_groups.id')
            ->orderBy('shelf', 'DESC');
        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }

        return $query->get();
    }



// Availibility for each cluster : grouped by Brands and Zones (Single date)  --- Boulbaba 27/01/2018
    public function get_shelf_cluster_channels($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('channels.name as channel'
            , 'product_groups.id as product_group_id'
            , 'brands.name as brand_name'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied')
        )
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'models.product_group_id', '=', 'product_groups.id')
            //->join('products', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('clusters.id', $cluster_id)
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('channels.id')
            //->groupBy('products.id')
            ->groupBy('product_groups.id')
            ->orderBy('shelf', 'DESC');
        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }

        return $query->get();
    }



// Shelf Share for each cluster : grouped by Brands and Outlet types (Single date)  --- Boulbaba 27/01/2018
    public function get_shelf_cluster_channels_old($date_type, $start_date, $end_date, $category_id, $cluster_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }

        $query = MyModel::select('channels.name as channel'
            , 'products.id as product_id'
            , DB::raw('sum(bcc_models.shelf) as shelf'),
            DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('clusters.id', $cluster_id)
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('channels.id')
            ->groupBy('products.id')
            ->orderBy('metrage', 'DESC');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }

        return $query->get();
    }

    public function get_total_shelf_by_zone($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }

        $query = MyModel::select('zones.name as zone'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied')
        )
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'models.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('zones.id')
            ->orderBy('visits.' . $date, 'desc');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }

        /*$results = $query->get();
        $sum_shelf = array();
        foreach ($results as $row) {
            $sum_shelf[$row->zone] = row->shelf;

        return $sum_shelf;*/

        $results = $query->get();
        $sum_shelf_array = array();

        foreach ($results as $row) {
            $sum_shelf_array[$row->zone] = $row->shelf;
            $sum_chapeau_array[$row->zone] = $row->chapeau;
            $sum_yeux_array[$row->zone] = $row->yeux;
            $sum_main_array[$row->zone] = $row->main;
            $sum_pied_array[$row->zone] = $row->pied;
        }

        $result_sum = array();
        $result_sum[] = $sum_shelf_array;
        $result_sum[] = $sum_chapeau_array;
        $result_sum[] = $sum_yeux_array;
        $result_sum[] = $sum_main_array;
        $result_sum[] = $sum_pied_array;
        //dd($result_sum);
        return $result_sum;
    }



    public function get_total_shelf_by_channels($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('channels.name as channel'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied')
        )
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'models.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('zones.id')
            ->orderBy('visits.' . $date, 'desc');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }

        /*$results = $query->get();
        $sum_shelf = array();
        foreach ($results as $row) {
            $sum_shelf[$row->zone] = row->shelf;

        return $sum_shelf;*/

        $results = $query->get();
        //dd($results);
        $sum_shelf_array = array();

        foreach ($results as $row) {
            $sum_shelf_array[$row->channel] = $row->shelf;
            $sum_chapeau_array[$row->channel] = $row->chapeau;
            $sum_yeux_array[$row->channel] = $row->yeux;
            $sum_main_array[$row->channel] = $row->main;
            $sum_pied_array[$row->channel] = $row->pied;
        }

        $result_sum = array();
        $result_sum[] = $sum_shelf_array;
        $result_sum[] = $sum_chapeau_array;
        $result_sum[] = $sum_yeux_array;
        $result_sum[] = $sum_main_array;
        $result_sum[] = $sum_pied_array;
        //dd($result_sum);
        return $result_sum;
    }


    public function get_total_shelf_by_channels_old($date_type, $start_date, $end_date, $category_id)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }

        $query = MyModel::select('channels.name as channel'
            , DB::raw('sum(bcc_models.shelf) as shelf'),
            DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('channels.id')
            ->orderBy('visits.' . $date, 'desc');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }


        $results = $query->get();
        $sum_shelf = array();
        foreach ($results as $row) {
            $sum_shelf[$row->channel] = $row->shelf;
        }

        return $sum_shelf;
    }

// Shelf Share grouped by Brands and Outlet types (Single date)  --- Boulbaba 27/01/2018
    public function get_shelf_single_date_brand_channels($date_type, $start_date, $end_date, $category_id, $zone_ids, $channel_ids)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('channels.name as channel'
            , 'brands.name as brand_name'
            , 'brands.color as color'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('(sum(CASE WHEN bcc_models.y = 1 THEN 1 ELSE 0 END)) as chapeau')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -10 THEN 1 ELSE 0 END)) as yeux')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -1 THEN 1 ELSE 0 END)) as main')
            , DB::raw('(sum(CASE WHEN bcc_models.y = -2 THEN 1 ELSE 0 END)) as pied'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'models.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->where('channels.active', 1)
            ->groupBy('channels.id')
            ->groupBy('brands.id')
            ->orderBy('shelf', 'desc');

        if ($category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        if (is_array($zone_ids) && !empty($zone_ids) && !is_null($zone_ids)) {
            $query->whereIn('zones.id', $zone_ids);
        } else if ($zone_ids != -1 && !is_null($zone_ids)) {
            $query->where('zones.id', '=', $zone_ids);
        }
        if (is_array($channel_ids) && !empty($channel_ids) && !is_null($channel_ids)) {
            $query->whereIn('channels.id', $channel_ids);
        } else if ($channel_ids != -1 && !is_null($channel_ids)) {
            $query->where('channels.id', '=', $channel_ids);
        }

        return $query->get();
    }

    function get_extarait_pdv_shelf_share_per_category_old($date_type, $start_date, $end_date, $category_id, $channel_id)
    {

        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select('products.id as product_id'
            , 'outlets.name as outlet_name'
            , DB::raw('sum(bcc_models.shelf) as shelf'),
            DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('count(bcc_models.id) as total'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
//                ->where('brands.selected','=', 1)
            ->whereIn('monthly_visit', array('1', '3'))
            ->groupBy('products.id')
            ->groupBy('outlets.id')
            ->orderBy('brands.id', 'asc')
            ->orderBy('outlets.name', 'asc');

        if ($channel_id && $channel_id != '-1') {
            $query->where('channels.id', '=', $channel_id);
        }

        if ($category_id && $category_id != '-1') {
            $query->where('categories.id', '=', $category_id);
        }
        return $query->get();
    }

    function get_extarait_pdv_shelf_share_per_category($date_type, $start_date, $end_date, $category_id, $channel_id)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }

        $query = MyModel::select('product_groups.id as product_id'
            , 'outlets.name as outlet_name'
            , DB::raw('sum(bcc_models.shelf) as shelf')
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage')
            , DB::raw('count(bcc_models.id) as total'))
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'));

        if ($channel_id && $channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }

        if ($category_id) {
            $query->where('categories.id', $category_id);
        }

        //$query->where('brands.name','HENKEL');

        $query->groupBy('product_groups.id')
            ->groupBy('outlets.name')
            ->orderBy('outlets.name')
            ->orderBy('brands.code');
        //dd($query->toSql());
//        dd($query->get());

        return $query->get();
    }

    //bcm
    public function get_total_metrage_by_outlets($date_type, $start_date, $end_date, $category_id, $channel_id)
    {
        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'q_date';
        }
        $query = MyModel::select(
            'outlets.name as outlet'
            , DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage'))
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.' . $date, '>=', $start_date)
            ->where('visits.' . $date, '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'));


        if ($category_id != '-1') {
            $query->where('categories.id', $category_id);
        }
        if ($channel_id && $channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }
        $query->groupBy('outlets.name')
            ->orderBy('visits.' . $date, 'desc');
        $results = $query->get();
        $sum_metrage = array();
        foreach ($results as $row) {
            $sum_metrage[$row->outlet] = $row->metrage;
        }

        return $sum_metrage;
    }

    //**********************************************************************************************************
    function get_branding_data($from, $to, $outlet_id, $fo_id, $zone_id)
    {

        $query = Visit::select('visits.id as id'
            , 'visits.date as date'
            //, 'visits.branding_pictures as branding_pictures'
            //, 'visits.one_pictures as one_pictures'
            , 'visit_pictures.branding_pictures as branding_pictures'
            , 'visit_pictures.one_pictures as one_pictures'
            , 'outlets.id as outlet_id'
            , 'outlets.name as outlet_name'
            , 'zones.name as zone_name'
            , 'outlets.photos as outlet_picture'
            , 'admin.name as fo_name')
            ->leftjoin('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->leftjoin('admin', 'admin.id', '=', 'outlets.admin_id')
            ->leftjoin('visit_pictures', 'visit_pictures.visit_id', '=', 'visits.id')
      ->where(function ($q) {
                $q->where('visit_pictures.branding_pictures', '!=', '[]')
                    ->orWhere('visits.one_pictures', '!=', '[]');
            })
            //->where('visits.branding_pictures', '!=', '[]')
//                ->orWhere('visits.one_pictures','!=','[]')
            ->orderBy('visits.date', 'desc')
            ->orderBy('outlets.id', 'desc')
            ->distinct();

        if ($from != '') {
            $query->where('visits.date', '>=', $from);
            $query->where('visits.date', '<=', $to);
        }

        if ($outlet_id != '-1') {
            $query->where('outlets.id', '=', $outlet_id);
        }

        if ($zone_id != -1) {
            $query->where('zones.id', '=', $zone_id);
        }

        if ($fo_id != -1) {
            $query->where('admin.id', '=', $fo_id);
        }
        return $query->get();
    }

    function get_store_album_data($outlet_id, $fo_id, $zone_id)
    {

        $query = Visit::select('visits.id as id'
            , 'outlets.name as outlet_name'
            , 'zones.name as zone_name'
            , 'outlets.photos as outlet_picture'
            , 'admin.name as fo_name'
            , 'visit_pictures.branding_pictures as new_branding_pictures'
            , 'visit_pictures.one_pictures as new_one_pictures'
            , DB::raw('MAX(bcc_visits.date) as date'))
            ->leftjoin('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->leftjoin('admin', 'admin.id', '=', 'outlets.admin_id')
            ->leftjoin('visit_pictures', 'visits.id', '=', 'visit_pictures.visit_id')
            ->where('visit_pictures.one_pictures', '!=', '[]')
		->where('visit_pictures.one_pictures', '!=', '')
            ->groupBy('outlets.id')
            ->orderBy('date', 'desc')
            ->orderBy('visits.id', 'desc')
            ->distinct();
        if ($outlet_id != '-1') {
            $query->where('outlets.id', '=', $outlet_id);
        }

        if ($zone_id != -1) {
            $query->where('zones.id', '=', $zone_id);
        }

        if ($fo_id != -1) {
            $query->where('admin.id', '=', $fo_id);
        }
        return $query->get();
    }

    public function get_price_monotoring_data($date, $channel_id, $category_id, $cluster_id)
    {

        $query = MyModel::select('outlets.name as outlet_name'
            , 'product_groups.id as product_id'
            , 'models.price as price'
            , 'models.promo_price as promo_price'
        )
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            //->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'models.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where(function ($q) {
                $q->where('models.price', '!=', 0)->orWhere('models.promo_price', '!=', 0);
            })
            ->whereIn('visits.monthly_visit', array('1', '2', '3'))
            ->groupBy('outlets.id')
            ->groupBy('product_groups.id')
            ->orderBy('brands.id', 'asc')
            ->orderBy('outlets.name', 'asc');


        if ($channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }

        if ($category_id != '-1') {
            $query->where('categories.id', $category_id);
        }

        if ($cluster_id != '-1') {
            $query->where('clusters.id', $cluster_id);
        }

        if ($date != '') {
            $query->where('visits.m_date', $date);
        }
        return $query->get();
    }

    public function get_routing_trend($date, $start_date, $end_date)
    {

        $dates = array();
        $choosed_day_lettre = date('l', strtotime($date));
        $start_date_traitement = $start_date;
        while (strtotime($start_date_traitement) <= strtotime($end_date)) {
            $today_letter = date('l', strtotime($start_date_traitement));
            if ($today_letter == $choosed_day_lettre) {
                $dates[] = $start_date_traitement;
            }
            $start_date_traitement = date('Y-m-d', strtotime($start_date_traitement . '+ 1 days'));
        }
        $query = FoPerformance::select('fo_performance.date as date'
            , 'admin.name as admin'
            , 'admin.id as admin_id'
            , 'was_there as alert'
            , DB::raw('avg(entry_time) AS entry_time')
            , DB::raw('avg(exit_time) AS exit_time')
            , DB::raw('avg(Gemo) as Gemo')
            , DB::raw('avg(UHD) as UHD')
            , DB::raw('avg(MG) as MG')
            , DB::raw('sum(nb_visits) as visits')
            , DB::raw('sum(total_branding) as branding')
            , DB::raw('sum(working_hours) as working_hours')
            , DB::raw('sum(travel_hours) as travel_hours'))
            ->join('admin', 'admin.id', '=', 'fo_performance.admin_id')
            ->groupBy('fo_performance.admin_id')
            ->groupBy('fo_performance.date')
            ->orderBy('date', 'asc');

        if (is_array($dates) && !empty($dates) && !is_null($dates)) {
            $query->whereIn('fo_performance.date', $dates);
        }
        return $query->get();
    }

    public function get_routing_survey_data($fo_id, $start_date, $end_date)
    {

        $query = Visit::select('visits.id as visit_id'
            , 'visits.w_date'
            , 'visits.date'
            , 'outlets.name as outlet_name'
            , 'outlets.id as outlet_id'
            , 'admin.id as admin_id'
            , 'admin.name as admin_name')
            ->leftjoin('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('admin', 'admin.id', '=', 'outlets.admin_id')
            ->orderBy('visits.id', 'asc');


        if ($start_date != '' && $end_date != '') {
            $query->where('visits.w_date', '>=', $start_date);
            $query->where('visits.w_date', '<=', $end_date);
        }
        if ($fo_id != '-1') {
            $query->where('admin.id', $fo_id);
        }
        return $query->get();
    }

    public function get_data_for_outlet_numeric_distribution($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id)
    {


        $query = MyModel::select(
            'visits.date as date'
            , 'outlets.*'
            , 'channels.name as channel_name'
            , 'channels.id as channel_id'
            , 'sub_channels.name as sub_channel_name'
            , 'zones.name as zone_name'
            , 'states.name as state_name'
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as av')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as ha')
            , DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as av_old')

        )
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
            ->join('channels', 'sub_channels.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('brands.id', '=', 1)
            ->where('channels.active', '=', 1)
            ->where('outlets.active', '=', 1)
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->groupBy('outlets.id');

        if ($category_id != 0) {
            $query->addSelect('categories.id as category_id');
            $query->where('categories.id', $category_id);
            //$query->group_by('categories.id');
        }

        if ($sub_category_id != 0) {
            $query->addSelect('sub_categories.id as sub_category_id');
            $query->where('sub_categories.id', $sub_category_id);
            //$query->group_by('sub_categories.id');
        }

        if ($cluster_id != 0) {
            $query->addSelect('clusters.id as cluster_id');
            $query->where('clusters.id', $cluster_id);
            //$query->group_by('clusters.id');
        }

        if ($product_group_id != 0) {
            $query->addSelect('product_groups.id as product_group_id');
            $query->where('product_groups.id', $product_group_id);
            //$query->group_by('product_groups.id');
        }

        if ($product_id != 0) {
            $query->addSelect('products.id as product_id');
            $query->where('products.id', $product_id);
            //$query->group_by('products.id');
        }

        if ($channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }

        return $query->get();
    }

    // Availibility grouped by Brands and Dates (Multi Dates) --- Boulbaba 26/01/2018
    public function get_data_per_state_for_outlet_numeric_distribution($start_date, $end_date, $channel_id, $av_type, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id)
    {

        $query = MyModel::select(
            'visits.date as date'
            , 'outlets.*'
            , 'channels.name as channel_name'
            , 'channels.id as channel_id'
            , 'sub_channels.name as sub_channel_name'
            , 'zones.name as zone_name'
            , 'states.*')
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
            ->leftjoin('channels', 'sub_channels.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('brands.id', 1)
            ->where('channels.active', 1)
            ->where('outlets.active', '=', 1)
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->groupBy('states.id');


        if ($av_type == 1) {
            //$query->addSelect(DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as data_av'));
            $query->addSelect(DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as data_av'));
        } elseif ($av_type == 2) {
            //$query->addSelect(DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as data_av'));
            $query->addSelect(DB::raw('((sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END))/(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)+sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)))*100 as data_av'));
        } elseif ($av_type == 3) {
            $query->addSelect(DB::raw('((sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as data_av'));
        }
        if ($category_id != 0) {
            $query->addSelect('categories.id as category_id');
            $query->where('categories.id', $category_id);
            //$query->group_by('categories.id');
        }

        if ($sub_category_id != 0) {
            $query->addSelect('sub_categories.id as sub_category_id');
            $query->where('sub_categories.id', $sub_category_id);
            //$query->group_by('sub_categories.id');
        }

        if ($cluster_id != 0) {
            $query->addSelect('clusters.id as cluster_id');
            $query->where('clusters.id', $cluster_id);
            //$query->group_by('clusters.id');
        }

        if ($product_group_id != 0) {
            $query->addSelect('product_groups.id as product_group_id');
            $query->where('product_groups.id', $product_group_id);
            //$query->group_by('product_groups.id');
        }

        if ($product_id != 0) {
            $query->addSelect('products.id as product_id');
            $query->where('products.id', $product_id);
            //$query->group_by('products.id');
        }

        if ($channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }
        return $query->get();
    }

    public function get_data_for_outlet_shelf_share_old($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id)
    {

        $query = MyModel::select(
            'visits.date as date'
            , 'outlets.*'
            , 'channels.name as channel_name'
            , 'channels.id as channel_id'
            , 'sub_channels.name as sub_channel_name'
            , 'zones.name as zone_name'
            , 'states.name as state_name'
            , 'visits.shelf_perc as shelf_perc'
            , DB::raw('sum(bcc_models.shelf) as shelf'), DB::raw('sum(bcc_models.shelf * bcc_product_groups.metrage) as metrage'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
            ->join('channels', 'sub_channels.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('brands.id', '=', 1)
            ->where('channels.active', '=', 1)
            ->where('outlets.active', '=', 1)
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('outlets.id');

        if ($category_id != 0) {
            $query->addSelect('categories.id as category_id');
            $query->where('categories.id', $category_id);
            //$query->group_by('categories.id');
        }

        if ($sub_category_id != 0) {
            $query->addSelect('sub_categories.id as sub_category_id');
            $query->where('sub_categories.id', $sub_category_id);
            //$query->group_by('sub_categories.id');
        }

        if ($cluster_id != 0) {
            $query->addSelect('clusters.id as cluster_id');
            $query->where('clusters.id', $cluster_id);
            //$query->group_by('clusters.id');
        }

        if ($product_group_id != 0) {
            $query->addSelect('product_groups.id as product_group_id');
            $query->where('product_groups.id', $product_group_id);
            //$query->group_by('product_groups.id');
        }

        if ($product_id != 0) {
            $query->addSelect('products.id as product_id');
            $query->where('products.id', $product_id);
            //$query->group_by('products.id');
        }

        if ($channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }

        return $query->get();
    }

    // Availibility grouped by Brands and Dates (Multi Dates) --- Boulbaba 26/01/2018
    public function get_data_per_state_for_outlet_shelf_share_old($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id)
    {

        $query = MyModel::select(
            'visits.date as date'
            , 'outlets.*'
            , 'channels.name as channel_name'
            , 'channels.id as channel_id'
            , 'sub_channels.name as sub_channel_name'
            , 'zones.name as zone_name'
            , 'states.*'
            , DB::raw('avg(bcc_visits.shelf_perc) as shelf_perc')
            , DB::raw('avg(bcc_models.shelf) as shelf'))
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
            ->leftjoin('channels', 'sub_channels.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->where('brands.id', 1)
            ->where('channels.active', 1)
            ->where('outlets.active', '=', 1)
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->groupBy('states.id');

        if ($category_id != 0) {
            $query->addSelect('categories.id as category_id');
            $query->where('categories.id', $category_id);
            //$query->group_by('categories.id');
        }

        if ($sub_category_id != 0) {
            $query->addSelect('sub_categories.id as sub_category_id');
            $query->where('sub_categories.id', $sub_category_id);
            //$query->group_by('sub_categories.id');
        }

        if ($cluster_id != 0) {
            $query->addSelect('clusters.id as cluster_id');
            $query->where('clusters.id', $cluster_id);
            //$query->group_by('clusters.id');
        }

        if ($product_group_id != 0) {
            $query->addSelect('product_groups.id as product_group_id');
            $query->where('product_groups.id', $product_group_id);
            //$query->group_by('product_groups.id');
        }

        if ($product_id != 0) {
            $query->addSelect('products.id as product_id');
            $query->where('products.id', $product_id);
            //$query->group_by('products.id');
        }

        if ($channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }

        return $query->get();
    }

//*************************************************************************************

    public function get_data_for_outlet_shelf_share($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id)
    {

        $query = MyModel::select(
            'visits.date as date'
            , 'outlets.*'
            , 'channels.name as channel_name'
            , 'channels.id as channel_id'
            , 'zones.name as zone_name'
            , 'states.name as state_name'
            , DB::raw('sum(bcc_models.shelf) as all_shelf')
            , DB::raw('sum(bcc_product_groups.metrage) as all_metrage'))
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->where('channels.active', '=', 1)
            ->where('outlets.active', '=', 1)
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->groupBy('outlets.id');

        if ($category_id != 0) {
            $query->addSelect('categories.id as category_id');
            $query->where('categories.id', $category_id);
        }

        if ($product_group_id != 0) {
            $query->addSelect('product_groups.id as product_group_id');
        }

        if ($channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }
        if ($product_group_id != 0) {
            $query->addSelect(DB::raw('(sum(CASE WHEN bcc_product_groups.id =' . $product_group_id . 'THEN bcc_models.shelf ELSE 0 END)/sum(bcc_models.shelf)) as shelf_perc')
                , DB::raw('sum(CASE WHEN bcc_product_groups.id =' . $product_group_id . 'THEN bcc_models.shelf ELSE 0 END) as shelf_henkel')
                , DB::raw('(sum(CASE WHEN bcc_product_groups.id =' . $product_group_id . 'THEN bcc_product_groups.metrage ELSE 0 END)/sum(bcc_product_groups.metrage)) as metrage_perc')
                , DB::raw('sum(CASE WHEN bcc_product_groups.id =' . $product_group_id . 'THEN bcc_product_groups.metrage ELSE 0 END) as metrage'));
        } // where brand henkel
        else {
            $query->addSelect(DB::raw('(sum(CASE WHEN bcc_brands.id =' . env('brand_id') . 'THEN bcc_models.shelf ELSE 0 END)/sum(bcc_models.shelf)) as shelf_perc')
                , DB::raw('sum(CASE WHEN bcc_brands.id =' . env('brand_id') . 'THEN bcc_models.shelf ELSE 0 END) as shelf_henkel')
                , DB::raw('(sum(CASE WHEN bcc_brands.id =' . env('brand_id') . 'THEN bcc_product_groups.metrage ELSE 0 END)/sum(bcc_product_groups.metrage)) as metrage_perc')
                , DB::raw('sum(CASE WHEN bcc_brands.id =' . env('brand_id') . 'THEN bcc_product_groups.metrage ELSE 0 END) as metrage_henkel'));
        }
        return $query->get();
    }

    public function get_data_per_state_for_outlet_shelf_share($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $cluster_id, $product_group_id, $product_id)
    {

        $query = MyModel::select(
            'visits.date as date'
            , 'outlets.*'
            , 'channels.name as channel_name'
            , 'channels.id as channel_id'
            , 'zones.name as zone_name'
            , 'states.*')
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'outlets.id', '=', 'visits.outlet_id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'product_groups.brand_id')
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->where('channels.active', '=', 1)
            ->where('outlets.active', '=', 1)
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->groupBy('states.id');

        if ($category_id != 0) {
            $query->addSelect('categories.id as category_id');
            $query->where('categories.id', $category_id);
        }

        if ($product_group_id != 0) {
            $query->addSelect('product_groups.id as product_group_id');
        }

        if ($channel_id != '-1') {
            $query->where('channels.id', $channel_id);
        }
        if ($product_group_id != 0) {
            $query->addSelect(DB::raw('(sum(CASE WHEN bcc_product_groups.id =' . $product_group_id . 'THEN bcc_models.shelf ELSE 0 END)/sum(bcc_models.shelf)) as shelf_perc')
                , DB::raw('sum(CASE WHEN bcc_product_groups.id =' . $product_group_id . 'THEN bcc_models.shelf ELSE 0 END) as shelf_henkel')
                , DB::raw('(sum(CASE WHEN bcc_product_groups.id =' . $product_group_id . 'THEN bcc_product_groups.metrage ELSE 0 END)/sum(bcc_product_groups.metrage)) as metrage_perc')
                , DB::raw('sum(CASE WHEN bcc_product_groups.id =' . $product_group_id . 'THEN bcc_product_groups.metrage ELSE 0 END) as metrage'));
        } // where brand henkel
        else {
            $query->addSelect(DB::raw('(sum(CASE WHEN bcc_brands.id =' . env('brand_id') . 'THEN bcc_models.shelf ELSE 0 END)/sum(bcc_models.shelf)) as shelf_perc')
                , DB::raw('sum(CASE WHEN bcc_brands.id =' . env('brand_id') . 'THEN bcc_models.shelf ELSE 0 END) as shelf_henkel')
                , DB::raw('(sum(CASE WHEN bcc_brands.id =' . env('brand_id') . 'THEN bcc_product_groups.metrage ELSE 0 END)/sum(bcc_product_groups.metrage)) as metrage_perc')
                , DB::raw('sum(CASE WHEN bcc_brands.id =' . env('brand_id') . 'THEN bcc_product_groups.metrage ELSE 0 END) as metrage_henkel'));
        }
        return $query->get();
    }

//**********************************************************    
// FO INFORMATION
    function save_fo_information($save)
    {
        DB::table('fo_informations')
            ->insert($save);
    }

    public function get_events()
    {

        return DB::table('fo_informations')
            ->groupBy('date_de_conge')
            ->get()->toArray();
    }

    public function get_events_details()
    {

        return DB::table('fo_informations')
            ->get()->toArray();
    }

    public function get_events_details_by_date($date)
    {
        return DB::table('fo_informations')
            ->select('fo_informations.*'
                , DB::raw('CAST(bcc_fo_informations.created as DATE) as created_date')
                , DB::raw('CAST(bcc_fo_informations.created as TIME) as created_time'))
            ->where("date_de_conge", $date)
            ->get();
    }

    public function add_event($data)
    {
        DB::table('fo_informations')
            ->insert($data);
    }

    public function get_event($id)
    {
        return DB::table('fo_informations')
            ->where("id", '=', $id)
            ->get();
    }

    function update_event($routing)
    {

        if ($routing['id']) {
            DB::table('fo_informations')
                ->where('id', '=', $routing['id'])
                ->update($routing);
            return $routing['id'];
        }
    }

    public function delete_event($id)
    {
        DB::table('fo_informations')
            ->where('id', '=', $id)
            ->delete();
    }

//Performance
    public function get_fo_performance($date_type, $start_date, $end_date)
    {

        if ($date_type == 'month') {
            $date = 'm_date';
        } else if ($date_type == 'week') {
            $date = 'w_date';
        } else {
            $date = 'date';
        }

        $query = FoPerformance::select('fo_performance.' . $date . ' as date',
            'admin.name as fo_name', 'admin.id as fo_id', 'was_there as alert'
            , DB::raw('avg(entry_time) AS entry_time')
            , DB::raw('avg(exit_time) AS exit_time')
            , DB::raw('avg(UHD) as UHD')
            , DB::raw('avg(MG) as MG')
            , DB::raw('avg(Gemo) as Gemo')
            , DB::raw('sum(nb_visits) as visits')
            , DB::raw('sum(total_branding) as branding')
            , DB::raw('sum(working_hours) as working_hours')
            , DB::raw('sum(travel_hours) as travel_hours'))
            ->join('admin', 'admin.id', '=', 'fo_performance.admin_id')
            ->where('fo_performance.' . $date, '>=', $start_date)
            ->where('fo_performance.' . $date, '<=', $end_date)
            ->groupBy('admin.id')
            ->groupBy('fo_performance.' . $date)
            ->orderBy('working_hours', 'desc');

        return $query->get();
    }

    public function get_oos_tracking()
    {
        $query = DB::select(DB::raw("SELECT bcc_oos_tracking . *,bcc_outlets.name as outlet_name,bcc_products.name as product_name
                                    FROM  `bcc_oos_tracking` 
                                    JOIN bcc_outlets ON bcc_oos_tracking.outlet_id = bcc_outlets.id
                                    JOIN bcc_products ON bcc_oos_tracking.product_id = bcc_products.id
                                    WHERE bcc_outlets.active =1
                                    AND bcc_oos_tracking.date < ( NOW( ) - INTERVAL 4 DAY ) 
                                    AND bcc_oos_tracking.nb_oos > 2
                                    ORDER BY  `bcc_oos_tracking`.`date` ,
                                    bcc_outlets.channel_id asc
                                    "));
        //dd($query);
        return $query;
    }

    function get_gps_monitoring_data_from_visits($fo_id, $date)
    {
        $query = Visit::select(
            'visits.date as date'
            , 'visits.entry_time as entry_time'
            , 'visits.longitude as lon'
            , 'visits.latitude as lat'
            , 'outlets.name as out_name'
            , 'states.*')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->where('visits.date', '=', $date)
            ->where('visits.admin_id', '=', $fo_id)
            ->where('visits.monthly_visit', 0)
            ->orderBy('entry_time', 'asc')
            ->get();
//              ->get()->toArray();

        return $query;
    }

    public function get_outlet_numeric_distribution($start_date, $end_date, $channel_id, $category_id, $sub_category_id, $product_group_id, $product_id)
    {
        $query = MyModel::select(
            'outlets.*',
            DB::raw('count(bcc_models.id) as total'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 1 THEN 1 ELSE 0 END)) as av'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END)) as oos'),
            DB::raw('(sum(CASE WHEN bcc_models.av = 2 THEN 1 ELSE 0 END)) as ha')
        //DB::raw('((sum(CASE WHEN bcc_models.av = 0 THEN 1 ELSE 0 END))/COUNT(bcc_models.id))*100 as oos')
        )
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'channels.id', '=', 'outlets.channel_id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('products', 'products.id', '=', 'models.product_id')
            ->join('product_groups', 'product_groups.id', '=', 'products.product_group_id')
            ->join('clusters', 'clusters.id', '=', 'product_groups.cluster_id')
            ->join('sub_categories', 'sub_categories.id', '=', 'clusters.sub_category_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id');

//        if ($av_type == 1) {
//            $query->select('100 - ((sum(bcc_models.av_sku)/count(bcc_models.id))*100) as oos');
//        } elseif ($av_type == 2) {
//            $query->select('(sum(bcc_models.av_sku)/count(bcc_models.id))*100 as av');
//        }
        if ($category_id != 0) {
            $query->addSelect('categories.id as category_id');
            $query->where('categories.id', $category_id);
            //$query->group_by('categories.id');
        }
        if ($sub_category_id != 0) {
            $query->addSelect('sub_categories.id as sub_category_id');
            $query->where('sub_categories.id', $sub_category_id);
            //$query->group_by('sub_categories.id');
        }
        if ($product_group_id != 0) {
            $query->addSelect('product_groups.id as product_group_id');
            $query->where('product_groups.id', $product_group_id);
            //$query->group_by('product_groups.id');
        }
        if ($product_id != 0) {
            $query->addSelect('products.id as product_id');
            $query->where('products.id', $product_id);
            //$query->group_by('products.id');
        }
        if ($channel_id != '-1') {
            $query->where_in('channels.id', $channel_id);
        }
        $query->where('brands.id', 1);
        $query->where('channels.active', 1);
        $query->where('visits.date', '>=', $start_date);
        $query->where('visits.date', '<=', $end_date);

        //$query->group_by('visits.date');
        $query->groupBy('outlets.id');
        return $query->get();
    }


}
