<?php

//pharmacie

namespace App\Repositories;

use App\Entities\MyModel;
use App\Entities\Visit;
use App\Repositories\MyModelRepository;
use DB;

class CronRepository extends ResourceRepository {

    protected $modelRepository;

    public function __construct(Visit $visit, MyModelRepository $modelRepository) {
        $this->model = $visit;
        $this->modelRepository = $modelRepository;
    }
    public function update_ha_avialibility($start_date=null)
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

    function save_oos_tracking($save) {
        //dd($save);
        $result = DB::table('oos_tracking')
                ->select('product_id', 'outlet_id')
                ->where('product_id', $save['product_id'])
                ->where('outlet_id', $save['outlet_id'])
                //$this->db->where('date <=', $save['date']);
                ->get();

        $num_rows = $result->count();
        //dd($result);
        if (($num_rows > 0) && ($save['av'] == 1 || $save['av'] == 2 )) {
            //echo $num_rows;
            //si le produit dans l outlet est av de nouveau : delete
            DB::table('oos_tracking')
                    ->where('product_id', '=', $save['product_id'])
                    ->where('outlet_id', '=', $save['outlet_id'])
                    ->delete();
        } else if (($num_rows > 0) && ($save['av'] == 0 )) {
            DB::table('oos_tracking')
                    ->where('product_id', '=', $save['product_id'])
                    ->where('outlet_id', '=', $save['outlet_id'])
                    ->increment('nb_oos', 1);

//                    ->update('oos_tracking');
        } else if (($num_rows == 0) && ($save['av'] == 0)) {
            DB::table('oos_tracking')->insert($save);
            //$id = $this->db->insert_id();
        }
    }

    public function get_oos_tracking() {
        $query = DB::select(DB::raw("SELECT cos_oos_tracking . *,cos_outlets.name as outlet_name,cos_products.name as product_name
                                    FROM  `cos_oos_tracking` 
                                    JOIN cos_outlets ON cos_oos_tracking.outlet_id = cos_outlets.id
                                    JOIN cos_products ON cos_oos_tracking.product_id = cos_products.id
                                    WHERE cos_outlets.active =1
                                    AND cos_oos_tracking.date < ( NOW( ) - INTERVAL 4 DAY ) 
                                    AND cos_oos_tracking.nb_oos > 2
                                    ORDER BY  `cos_oos_tracking`.`date` ,
                                    cos_oos_tracking.outlet_id ASC
                                    "));
        //dd($query);
        return $query;
    }

//
//    function count_oos_tracking() {
//
//        $query = $this->db->query("SELECT bcc_oos_tracking . id
//                                    FROM  `bcc_oos_tracking` 
//                                    JOIN bcc_outlets ON bcc_oos_tracking.outlet_id = bcc_outlets.id
//                                    JOIN bcc_products ON bcc_oos_tracking.product_id = bcc_products.id
//                                    WHERE bcc_outlets.active =1
//                                    AND bcc_oos_tracking.date < ( NOW( ) - INTERVAL 4 DAY )");
//        return $query->num_rows();
//    }


    public function get_oos_fo($admin_id, $date, $channel_id) {
        $oos = DB::table('models')
                ->select(DB::raw('((sum(CASE WHEN cos_models.av_sku = 0 THEN 1 ELSE 0 END))/COUNT(cos_models.id))*100 as oos'))
                ->join('visits', 'models.visit_id', '=', 'visits.id')
                ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
                ->join('channels', 'outlets.channel_id', '=', 'channels.id')
                ->join('products', 'models.product_id', '=', 'products.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('admin', 'admin.id', '=', 'visits.admin_id')
                ->where('products.active', '=', 1)
                ->where('products.active', '=', 1)
                ->where('channels.id', '=', $channel_id)
                ->where('admin.id', '=', $admin_id)
                ->where('visits.date', '=', $date)
                ->where('brands.id', '=', env('brand_id'))
                ->get();
        return $oos;
    }

    function save_fo_performance($save) {

        if ($save['id']) {
            DB::table('fo_performance')
                    ->where('id', '=', $save['id'])
                    ->update('fo_performance', '=', $save);
            return $save['id'];
        } else {
            $id = DB::table('fo_performance')->insertGetId(
                    $save
            );
            return $id;
        }
    }

    function get_visits_by_admin($admin_id, $date) {
        $result = DB::table('visits')
                ->select('visits.*'
                        , DB::raw('CAST(cos_visits.created as TIME) as system_exit_time'))
                ->leftjoin('admin', 'visits.admin_id', '=', 'admin.id')
                ->where('visits.date', '=', $date)
                ->where('admin.id', '=', $admin_id)
                ->orderBy('visits.entry_time', 'ASC')
                ->get();
        return $result;
    }

}
