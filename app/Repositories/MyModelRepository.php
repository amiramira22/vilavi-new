<?php

//pharmacie

namespace App\Repositories;

use App\Entities\MyModel;
use DB;

class MyModelRepository extends ResourceRepository
{

    public function __construct(MyModel $model)
    {
        $this->model = $model;
    }

    public function get_models($visit_id)
    {

        $model = MyModel::where('models.visit_id', '=', $visit_id);
        return $model->get();
    }

    public function count_models_by_brand($visit_id, $brand_id)
    {

        $model = MyModel::where('models.visit_id', '=', $visit_id)
            ->where('brand_id', '=', $brand_id);
        return $model->count();
    }

    function get_nb_oos($visit_id)
    {
        $model = MyModel::where('av', 0)
            ->where('brand_id', 1)
            ->where('visit_id', $visit_id);
        return $model->count();
    }

    function get_sum_shelf($visit_id)
    {

        $model = MyModel::select(DB::raw('sum(cos_models.shelf) as total'))
            ->where('visit_id', $visit_id);
        return $model->first();
    }

    function get_sum_shelf_henkel($visit_id)
    {

        $model = MyModel::select(DB::raw('sum(cos_models.shelf) as total'))
            ->where('brand_id', 1)
            ->where('visit_id', $visit_id);
        return $model->first();
    }

    function get_detail_models($visit_id)
    {

        $models = MyModel::leftjoin('visits', 'models.visit_id', '=', 'visits.id')
            ->leftjoin('product_groups', 'product_groups.id', '=', 'models.product_group_id')
            ->leftjoin('brands', 'product_groups.brand_id', '=', 'brands.id')
            ->select('models.id as id'
                , 'models.product_group_id as product_group_id'
                , 'product_groups.name as product_name'
                , 'models.brand_id as brand_id'
                , 'brands.name as brand_name'
                , 'models.nb_sku as nb_sku'
                , 'models.av_sku as av_sku'
                , 'models.sku_display as sku_display'
                , 'brands.name as brand_name'
                , 'models.shelf as shelf'
                , 'models.av as av'
                , 'models.y as ny'
                , 'models.price as price'
                , 'models.promo_price as promo_price')
            ->where('visits.id', '=', $visit_id)
            ->orderBy('brands.id', 'ASC')
            ->orderBy('product_groups.category_id', 'ASC');
        return $models->get();
    }

    function get_detail_daily_models($visit_id)
    {

        $models = MyModel::leftjoin('visits', 'models.visit_id', '=', 'visits.id')
            ->leftjoin('products', 'models.product_id', '=', 'products.id')
            ->leftjoin('brands', 'models.brand_id', '=', 'brands.id')
            ->select('models.*', 'products.name as product_name', 'brands.name as brand_name')
            ->where('visits.id', '=', $visit_id)
            ->orderBy('brands.id', 'ASC')
            ->orderBy('products.code', 'ASC');
        return $models->get();
    }

    public function checkModel($visit_id, $model_id)
    {

        $model = MyModel::select('models.*')
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->where('visits.id', $visit_id)
            ->where('models.id', $model_id)
            ->first();
        return $model;
    }

    public function getModelByVisitId($visit_id)
    {

        $model = MyModel::select('models.*')
            ->join('visits', 'visits.id', '=', 'models.visit_id')
            ->where('visits.id', $visit_id)
            ->get();
        return $model;
    }

    public function addOrUpdateModel($save, $id = '')
    {

        if ($id == '') {
            $id = DB::table('models')->insertGetId(
                $save
            );
        } else {
            DB::table('models')
                ->where('models.id', $id)
                ->update($save);
        }
        return $id;
    }

    public function getAvDailyVisitReport($date, $fo_id, $channel_id, $responsible_id)
    {

        $report = MyModel::select(
            'outlets.id as outlet_id',
            'products.id as product_id',
            'models.av as av', 'zones.name as zone_name', 'channels.name as channel_name',
            'outlets.name as outlet_name', 'products.name as product_name',
            'brands.name as brand_name')
            ->join('products', 'models.product_id', '=', 'products.id')
            //
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            //
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('admin', 'visits.admin_id', '=', 'admin.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('brands.id', env('brand_id'))
            ->groupBy('outlets.id')
            ->groupBy('products.name')
            //
            ->orderBy('categories.id', 'ASC')
            ->orderBy('clusters.id', 'ASC')
            //
            ->orderBy('products.code', 'ASC')
            ->orderBy('products.code', 'ASC')
            ->orderBy('brands.id', 'ASC')
            ->orderBy('zones.code', 'ASC');


        if ($fo_id != -1) {
            $report->where('admin.id', $fo_id);
        }
        if ($responsible_id != -1) {
            $report->where('outlets.responsible_id', $responsible_id);
        }
        if ($channel_id != -1) {
            $report->where('channels.id', $channel_id);
        }
        if ($date != '') {
            $report->where('visits.date', $date);
        }
        return $report->get();
    }

    public function getPosData($start_date, $end_date, $outlet_id, $channel_id, $zone_id)
    {

//, DB::raw('(sum(CASE WHEN models.av = 1 THEN 1 ELSE 0 END)) as av'), DB::raw('(sum(CASE WHEN models.av = 0 THEN 1 ELSE 0 END)) as oos'), DB::raw('(sum(CASE WHEN models.av = 2 THEN 1 ELSE 0 END)) as ha'), DB::raw('COUNT(models.id) as total'),
        $report = MyModel::select('outlets.id as outlet_id', 'products.id as product_id', 'models.av as av', 'zones.name as zone_name', 'channels.name as channel_name', 'outlets.name as outlet_name', 'products.name as product_name', 'brands.name as brand_name', 'visits.date as date')
            ->join('products', 'models.product_id', '=', 'products.id')
            ->join('visits', 'models.visit_id', '=', 'visits.id')
            ->join('admin', 'visits.admin_id', '=', 'admin.id')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->groupBy('visits.date')
            ->groupBy('products.id')
            ->orderBy('brands.id', 'asc')
            ->orderBy('visits.date', 'asc');

        if ($start_date != '' && $end_date != '') {
            $report->where('visits.date', '>=', $start_date);
            $report->where('visits.date', '<=', $end_date);
        }
        if ($outlet_id != '-1') {
            $report->where('outlets.id', $outlet_id);
        }
        if ($channel_id != '-1') {
            $report->where('channels.id', $channel_id);
        }
        if ($zone_id != '-1') {
            $report->where('zones.id', $zone_id);
        }
        return $report->get();
    }

}
