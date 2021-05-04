<?php

namespace App\Repositories;

use App\Entities\ResponsibleOrder;
use App\Entities\Visit;
use App\Entities\Outlet;

use App\Repositories\MyModelRepository;
use DB;

class VisitRepository extends ResourceRepository
{

    protected $modelRepository;

    public function __construct(Visit $visit, MyModelRepository $modelRepository)
    {
        $this->model = $visit;
        $this->modelRepository = $modelRepository;
    }

    public function getAjaxVisits($start = 0, $limit = 0, $order = 'visits.id', $dir = '', $draw = 0, $search = '-1', $start_date = '', $end_date = '', $visit_type = '-1', $user_id = '-1')
    {
        //d($start_date);
        // get visits filtred rows
        $visits = Visit::leftjoin('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->leftjoin('states', 'outlets.state_id', '=', 'states.id')
            ->leftjoin('admin', 'visits.admin_id', '=', 'admin.id')
            ->select('visits.*'
                , 'channels.name as channel_name'
                , 'zones.name as zone_name'
                , 'states.name as state_name'
                , 'outlets.name as outlet_name'
                , 'admin.name as fo_name'
                , 'outlets.latitude as outlet_lat'
                , 'outlets.longitude as outlet_long'
                , DB::raw('CAST(bcc_visits.created as DATE) as created_date')
                , DB::raw('CAST(bcc_visits.created as TIME) as created_time'));

        if ($visit_type == 1) {
            $visits->whereIn('visits.monthly_visit', array(1, 3));
        } else if ($visit_type == 2) {
            $visits->whereIn('visits.monthly_visit', array(2, 3));
        } else if ($visit_type == 0) {
            $visits->where('visits.monthly_visit', 0);
        }


        if ($user_id != '-1') {
            $visits->where('admin.id', $user_id);
        }

        if ($start_date != '' && $end_date != '') {
            //dd('$start_date');
            $visits->where('visits.date', '>=', $start_date);
            $visits->where('visits.date', '<=', $end_date);
        }

        if ($search != '-1') {
            $visits->where(function ($q) use ($search) {
                $q->where('admin.name', 'like', "%{$search}%")
                    ->orWhere('outlets.name', 'like', "%{$search}%")
                    ->orWhere('zones.name', 'like', "%{$search}%")
                    ->orWhere('states.name', 'like', "%{$search}%")
                    ->orWhere('visits.date', 'like', "%{$search}%")
                    ->orWhere('visits.entry_time', 'like', "%{$search}%")
                    ->orWhere('visits.exit_time', 'like', "%{$search}%")
                    ->orWhere('visits.oos_perc', 'like', "%{$search}%")
                    ->orWhere('visits.shelf_perc', 'like', "%{$search}%")
                    ->orWhere('visits.remark', 'like', "%{$search}%");
            });
//            $visits->where('admin.name', 'like', "%{$search}%");
//            $visits->orWhere('outlets.name', 'like', "%{$search}%");
//            $visits->orWhere('zones.name', 'like', "%{$search}%");
//            $visits->orWhere('states.name', 'like', "%{$search}%");
//            $visits->orWhere('visits.date', 'like', "%{$search}%");
//            $visits->orWhere('visits.entry_time', 'like', "%{$search}%");
//            $visits->orWhere('visits.exit_time', 'like', "%{$search}%");
//            $visits->orWhere('visits.oos_perc', 'like', "%{$search}%");
//            $visits->orWhere('visits.shelf_perc', 'like', "%{$search}%");
//            $visits->orWhere('visits.remark', 'like', "%{$search}%");
        }

        $visits->offset($start);
        $visits->limit($limit);
        $visits->orderBy($order, $dir);
        $visits = $visits->get();
        //dd($visits);
        // Total visits rows
        $totalData = $this->countVisits($search, $start_date, $end_date, $visit_type, $user_id);
        $totalFiltered = $totalData;

        $data = array();
        if ($visits) {

            foreach ($visits as $v) {
                $nestedData['id'] = $v->id;
                $nestedData['fo'] = $v->fo_name;

                if ($v->monthly_visit == 1 || $v->monthly_visit == 3)
                    $nestedData['outlet'] = '<a href = "visit/position/' . $v->id . '/all" class = "" title = "Visit position details" target = "_blank">'
                        . '<font color = "red">' . $v->outlet_name . '</font>'
                        . '</a>';
                else
                    $nestedData['outlet'] = '<a href = "visit/position/' . $v->id . '/all" class = "" title = "Visit position details" target = "_blank">'
                        . $v->outlet_name
                        . '</a>';


                $nestedData['channel'] = $v->channel_name;
                $nestedData['zone'] = $v->zone_name;
                $nestedData['state'] = $v->state_name;

                if ($v->date != $v->created_date)
                    $nestedData['date'] = '<span class="blink_me" style="color: #F03434">' . reverse_format($v->date) . '</span>
                                            <span title="created_date on  ' . reverse_format($v->created_date) . '"
                                                  <i class="fa fa-info-circle"></i>
                                            </span>';
                else
                    $nestedData['date'] = reverse_format($v->date);

                //enry time traitement
                if (\request()->session()->get('connected_user_acces') == 'Admin') {

                    if ($v->was_there == 0)
                        $nestedData['entry_time'] = '<span class="blink_me" style="color: #F03434">' . $v->entry_time . '</span>
                                            <a style="color: #F03434" target="_blank" href="visit/position/' . $v->id . '/entry" >
                                                <i class="flaticon-placeholder-2"></i></a>';
                    else
                        $nestedData['entry_time'] = $v->entry_time;
                } else   $nestedData['entry_time'] = $v->entry_time;


                //exit time traitement
                if (\request()->session()->get('connected_user_acces') == 'Admin') {

                    if (is_numeric($v->outlet_lat) && is_numeric($v->outlet_lat)
                        && is_numeric($v->exit_latitude) && is_numeric($v->exit_longitude)) {
                        $exit_was_there = was_there($v->outlet_lat, $v->outlet_long,
                            $v->exit_latitude, $v->exit_longitude);
                    } else
                        $exit_was_there = false;

                    if (($v->exit_latitude != '') && ($exit_was_there == 0)) {

                        $Time = strtotime("-60 minutes", strtotime($v->created_time));
                        $Time = strtotime($v->created_time);

                        $nestedData['exit_time'] = '<span class="blink_me" style="color: #F03434">' . $v->exit_time . '</span>
                                            <a style="color: #F03434" target="_blank" href="visit/position/' . $v->id . '/exit" >
                                                <i class="flaticon-placeholder-2"></i>
                                            </a>';
                    } else
                        $nestedData['exit_time'] = $v->exit_time;

                } else $nestedData['exit_time'] = $v->exit_time;


                $nestedData['oos'] = number_format(($v->oos_perc), 2, ',', ' ');

                if ($v->monthly_visit == 1 || $v->monthly_visit == 3)
                    $nestedData['shelf'] = number_format($v->shelf_perc * 100, 2, ',', ' ');
                else
                    $nestedData['shelf'] = '-';


                $nestedData['branding'] = substr_count($v->branding_pictures, ".jpg") / 2;

                $count = substr_count($v->order_picture, ".jpg");
                if ($count == 0) {
                    $nestedData['order'] = '';
                } else {
                    $nestedData['order'] = '
                <a href = "visit/order_report/' . $v->id . '" target = "_blank">
                <i class = "icon-md fas fa-file-invoice text-danger"></i></a>';

                }

                if ($v->remark != '')
                    $nestedData['remark'] = '<a type = "textarea"
                title = "' . $v->remark . '"
                name = "description"><i class = "fa fa-info-circle"
                style = "color: #f4516c !important"></i></a>';
                else
                    $nestedData['remark'] = '';


                if (\request()->session()->get('connected_user_acces') == 'Admin') {

                    $nestedData['action'] = '

          
                        <span class="dropdown">
                        
<button type="button" class="btn btn-sm btn-light-danger dropdown-toggle" 
data-toggle="dropdown"
 aria-haspopup="true" aria-expanded="false" >Action</button>
 
                        <!--<button target="_blank" 
                        class="btn m-btn m-btn&#45;&#45;hover-brand m-btn&#45;&#45;icon m-btn&#45;&#45;icon-only m-btn&#45;&#45;pill" 
                        data-toggle="dropdown" aria-expanded="true">
                <i class = "fas fa-ellipsis-h"></i>
                </button>-->

                <div class = "dropdown-menu dropdown-menu-right" >
<div class="package-rating-detail">
<a href = "visit/report/' . $v->id . '"
 class = "dropdown-item" 
 title="Report" target="_blank">	
                            <i class="fas fa-chart-line"></i>   Report			
                            </a>
</div>
<div class="package-rating-detail">

                <a href = "visit/models/' . $v->id . '" class = "dropdown-item" title = "Model Data" target = "_blank">
                <i class = "fas fa-list"></i>   Model Data
                </a></div>
<div class="package-rating-detail">

                <a href = "visit/edit/' . $v->id . '" class = "dropdown-item" title = "Edit details" target = "_blank">
                <i class = "fas fa-edit"></i>   Edit
                </a>
</div>
      <div class="package-rating-detail">

                <a href = "visit/delete/' . $v->id . '" onclick = "return confirm(\'Are you sure you want to delete this visit ?\')" class = "dropdown-item" title = "Delete" id = "del">
                <i class = "fas fa-trash"></i>   Delete
                </a>
</div>
      <div class="package-rating-detail">

                <a href = "visit/copy/' . $v->id . '" class = "dropdown-item" title = "Copy" target = "_blank">
                <i class = "fas fa-copy"></i>   Copy
                </a>
</div>
                </div>
                </span>';
                } else {
                    $nestedData['action'] = '<button type="button" 
class="btn btn-sm btn-light-danger"><a href = "visit/report/' . $v->id . '"
 title="Report" target="_blank">	
                            <i class="fas fa-chart-line"></i>   Report			
                            </a></button>';
                }
                $data[] = $nestedData;
            }
        }

        return array(
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
    }


    public function getAjaxOrderVisits($start = 0, $limit = 0, $order = 'visits.oos_perc', $dir = 'desc', $draw = 0,
                                       $search = '-1', $start_date = '', $end_date = '',
                                       $zone_ids = -1, $fo_ids = -1, $responsible_order_selected)
    {

        $ids_visit_has_order = array();
        $visitshasorder = ResponsibleOrder::select('*')->get();
        foreach ($visitshasorder as $v) {
            $ids_visit_has_order[] = $v->visit_id;
        }
        // get visits filtred rows
        $visits = Visit::leftjoin('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->leftjoin('states', 'outlets.state_id', '=', 'states.id')
            ->leftjoin('admin', 'visits.admin_id', '=', 'admin.id')
            ->select('visits.*'
                , 'visits.id as visit_id'
                , 'channels.name as channel_name'
                , 'zones.name as zone_name'
                , 'states.name as state_name'
                , 'outlets.name as outlet_name'
                , 'admin.name as fo_name'
                , DB::raw('CAST(bcc_visits.created as DATE) as created_date')
                , DB::raw('CAST(bcc_visits.created as TIME) as created_time'))
            ->where('visits.monthly_visit', 0)
            ->whereIn('order_picture', array(null, '','[]'));
           

                //missed
                if ($responsible_order_selected == 1) {
                    $visits->whereNotIn('visits.id', $ids_visit_has_order);
                }
                //done
                if ($responsible_order_selected == 0) {

                    $visits
                        ->join('responsible_order', 'responsible_order.visit_id', '=', 'visits.id')
                        ->addSelect('responsible_order.*')
                        ->whereIn('visits.id', $ids_visit_has_order);
                }
                if (!empty($zone_ids) && $zone_ids != '-1') {
                    $visits->whereIn('zones.id', $zone_ids);
                }
                if (!empty($fo_ids) && $fo_ids != '-1') {
                    $visits->whereIn('admin.id', $fo_ids);
                }
                if ($start_date != '' && $end_date != '') {
                    //dd('$start_date');
                    $visits->where('visits.date', '>=', $start_date);
                    $visits->where('visits.date', '<=', $end_date);
                }


                if ($search != '-1') {
                    $visits->where(function ($q) use ($search) {
                        $q->where('admin.name', 'like', "%{$search}%")
                            ->orWhere('outlets.name', 'like', "%{$search}%")
                            ->orWhere('zones.name', 'like', "%{$search}%")
                            ->orWhere('states.name', 'like', "%{$search}%")
                            ->orWhere('visits.date', 'like', "%{$search}%")
                            ->orWhere('visits.oos_perc', 'like', "%{$search}%");
                    });
                }
                $visits->offset($start);
                $visits->limit($limit);
                $visits->orderBy($order, $dir);
                $visits = $visits->get();
                //dd($visits);
                // Total visits rows
                $totalData = $this->countMissedOrderVisits($search, $start_date, $end_date, $zone_ids,
                    $fo_ids, $responsible_order_selected, $ids_visit_has_order);
                $totalFiltered = $totalData;

                $data = array();
                if ($visits) {

                    foreach ($visits as $v) {

                        $nestedData['fo'] = $v->fo_name;

                        $nestedData['outlet'] = '<a href = "visit/position/' . $v->visit_id . '/all" class = "" title = "Visit position details" target = "_blank">'
                            . $v->outlet_name
                            . '</a>';


                        $nestedData['channel'] = $v->channel_name;
                        $nestedData['zone'] = $v->zone_name;
                        $nestedData['state'] = $v->state_name;


                        $nestedData['date'] = reverse_format($v->date);


                        $nestedData['oos'] = number_format(($v->oos_perc), 2, ',', ' ');


                        $nestedData['report'] = '<button type="button" 
class="btn btn-sm btn-light-danger"><a href = "/visit/report/' . $v->visit_id . '"
 title="Report" target="_blank">	
                            <i class="fas fa-chart-line"></i>   Report			
                            </a></button>';
                        $exist= in_array($v->visit_id, $ids_visit_has_order, false);

                        /////////////
                        if ($responsible_order_selected == 0 && request()->session()->get('connected_user_acces') != 'Responsible') {

                            $nestedData['action'] = '
                <a href="#"  onclick="setOrderPhoto(\'' . $v->random_file_name . '\')"          
                   data-toggle="modal" data-target="#m_modal_ShowOrder">
                                 <i class="ficon-md fas fa-clipboard-list text-danger"></i> Show Order
                </a>';
                        }
                        else if ($responsible_order_selected == 1 && request()->session()->get('connected_user_acces') != 'Responsible') {

                            $nestedData['action'] = '';
                        }
                        /////////
                        else if ($exist==true && request()->session()->get('connected_user_acces') == 'Responsible') {
                            $nestedData['action'] = '';
                        }
                        else{
                            $nestedData['action'] = '
                <a href="#"  onclick="setVisitID(' . $v->visit_id . ')"
                   data-toggle="modal" data-target="#m_modal_4">
                                Upload   <i class="fas fa-upload text-danger"></i>
                </a>';
                        }
                        //////////


                        $data[] = $nestedData;
                    }
                }

                return array(
                    "draw" => intval($draw),
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );
            }

    public function addFile($save, $id = '')
    {

        if ($id == '') {
            $id = DB::table('responsible_order')->insertGetId(
                $save
            );
        } else {
            DB::table('responsible_order')
                ->where('responsible_order.id', $id)
                ->update($save);
        }
        return $id;
    }

    public function countVisits($search = '-1', $start_date = '', $end_date = '', $visit_type = -1, $user_id = -1)
    {
        $visits = DB::table('visits')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('admin', 'visits.admin_id', '=', 'admin.id');
        if ($search != '-1') {
            $visits->where(function ($q) use ($search) {
                $q->where('admin.name', 'like', "%{$search}%")
                    ->orWhere('outlets.name', 'like', "%{$search}%")
                    ->orWhere('zones.name', 'like', "%{$search}%")
                    ->orWhere('states.name', 'like', "%{$search}%")
                    ->orWhere('visits.date', 'like', "%{$search}%")
                    ->orWhere('visits.entry_time', 'like', "%{$search}%")
                    ->orWhere('visits.exit_time', 'like', "%{$search}%")
                    ->orWhere('visits.oos_perc', 'like', "%{$search}%")
                    ->orWhere('visits.shelf_perc', 'like', "%{$search}%")
                    ->orWhere('visits.remark', 'like', "%{$search}%");
            });
        }
        if ($visit_type == 1) {
            $visits->whereIn('visits.monthly_visit', array(1, 3));
        } else if ($visit_type == 2) {
            $visits->whereIn('visits.monthly_visit', array(2, 3));
        } else if ($visit_type == 0) {
            $visits->where('visits.monthly_visit', 0);
        }


        if ($user_id != '-1') {
            $visits->where('admin.id', $user_id);
        }

        if ($start_date != '' && $end_date != '') {
            $visits->where('visits.date', '>=', $start_date);
            $visits->where('visits.date', '<=', $end_date);
        }
        return $visits->count();
    }


    public function countMissedOrderVisits($search, $start_date, $end_date,
                                           $zone_ids, $fo_ids,
                                           $responsible_order_selected, $ids_visit_has_order)
    {
        $ids_visit_has_order = array();
        $visitshasorder = ResponsibleOrder::select('*')->get();
        foreach ($visitshasorder as $v) {
            $ids_visit_has_order[] = $v->visit_id;
        }

        $visits = DB::table('visits')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('zones', 'outlets.zone_id', '=', 'zones.id')
            ->join('channels', 'outlets.channel_id', '=', 'channels.id')
            ->join('states', 'outlets.state_id', '=', 'states.id')
            ->join('admin', 'visits.admin_id', '=', 'admin.id')
            ->where('visits.monthly_visit', 0)
            ->whereIn('order_picture', array(null, '','[]'));
         /*   ->where(function ($q) {
                $q->whereIn('order_picture', array(null, ''))
                    ->orWhere('order_picture', []);
            });*/
        if ($search != '-1') {
            $visits->where(function ($q) use ($search) {
                $q->where('admin.name', 'like', "%{$search}%")
                    ->orWhere('outlets.name', 'like', "%{$search}%")
                    ->orWhere('zones.name', 'like', "%{$search}%")
                    ->orWhere('states.name', 'like', "%{$search}%")
                    ->orWhere('visits.date', 'like', "%{$search}%");


            });
        }
        //missed
        if ($responsible_order_selected == 1) {
            $visits->whereNotIn('visits.id', $ids_visit_has_order);
        }
        //done
        if ($responsible_order_selected == 0) {

            $visits
                ->join('responsible_order', 'responsible_order.visit_id', '=', 'visits.id')
                ->addSelect('responsible_order.*')
                ->whereIn('visits.id', $ids_visit_has_order);
        }
        if (!empty($zone_ids) && $zone_ids != '-1') {
            $visits->whereIn('zones.id', $zone_ids);
        }
        if (!empty($fo_ids) && $fo_ids != '-1') {
            $visits->whereIn('admin.id', $fo_ids);
        }

        if ($start_date != '' && $end_date != '') {
            $visits->where('visits.date', '>=', $start_date);
            $visits->where('visits.date', '<=', $end_date);
        }

        return $visits->count();
    }

    public function getVisits($search = '')
    {

        $visits = Visit::select('visits.*')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('code')
            ->paginate(20);
        //set the value of the search
        $visits->appends(['search' => $search]);
        //  dd($visits);
        return $visits;
    }

    public function addVisit($save, $id = '')
    {

        if ($id == '') {
            $id = DB::table('visits')->insertGetId(
                $save
            );
        } else {
            DB::table('visits')
                ->where('visits.id', $id)
                ->update($save);
        }
        return $id;
    }

    public function deleteVisit($id)
    {

        DB::table('visits')->where('visits.id', $id)->delete();
    }

    public function getVisitById($id)
    {

        $visit = Visit::select('visits.*'
            , 'visit_pictures.branding_pictures as new_branding_pictures'
            , 'visit_pictures.one_pictures as new_one_pictures')
            ->leftjoin('visit_pictures', 'visit_pictures.visit_id', '=', 'visits.id')
            ->where('visits.id', $id)
            ->first();
        //dd($visit);
        return $visit;
    }

    function copy($visit, $visit_id)
    {

        $new_visit_id = $this->addVisit($visit);
        $models = $this->modelRepository->get_models($visit_id);
        //dd($models);
        foreach ($models as $model) {
            $data['id'] = false;
            $data['visit_id'] = $new_visit_id;
            $data['visit_uniqueId'] = $model->visit_uniqueId;
            $data['av'] = $model->av;
            $data['price'] = $model->price;
            $data['promo_price'] = $model->promo_price;
            $data['shelf'] = $model->shelf;
            $data['product_id'] = $model->product_id;
            $data['brand_id'] = $model->brand_id;
            $data['category_id'] = $model->category_id;
            $data['cluster_id'] = $model->cluster_id;
            $data['product_group_id'] = $model->product_group_id;
            $data['target'] = $model->target;
            $data['av_sku'] = $model->av_sku;
            $data['nb_sku'] = $model->nb_sku;
            $data['sku_display'] = $model->sku_display;

            $this->modelRepository->addOrUpdateModel($data);
        }

        return $new_visit_id;
    }

    function save_oos_tracking($save)
    {
        //dd($save);
        $result = DB::table('oos_tracking')
            ->select('product_id', 'outlet_id')
            ->where('product_id', $save['product_id'])
            ->where('outlet_id', $save['outlet_id'])
            //$visits->where('date <= ', $save['date']);
            ->get();

        $num_rows = $result->count();
        //dd($result);
        if (($num_rows > 0) && ($save['av'] == 1 || $save['av'] == 2)) {
            //echo $num_rows;
            //si le produit dans l outlet est av de nouveau : delete
            DB::table('oos_tracking')
                ->where('product_id', ' = ', $save['product_id'])
                ->where('outlet_id', ' = ', $save['outlet_id'])
                ->delete();
        } else if (($num_rows > 0) && ($save['av'] == 0)) {
            DB::table('oos_tracking')
                ->where('product_id', ' = ', $save['product_id'])
                ->where('outlet_id', ' = ', $save['outlet_id'])
                ->increment('nb_oos', 1);

//                    ->update('oos_tracking');
        } else if (($num_rows == 0) && ($save['av'] == 0)) {
            DB::table('oos_tracking')->insert($save);
            //$id = $visits->insert_id();
        }
    }

    function get_branding_data($from, $to, $outlet_id, $fo_id, $zone_id)
    {

        $query = Visit::select(
            'visits.id as id'
            , 'visits.date as date'
            , 'visits.branding_pictures as branding_pictures'
            , 'visits.one_pictures as one_pictures'
            , 'outlets.id as outlet_id'
            , 'outlets.name as outlet_name'
            , 'zones.name as zone_name'
            , 'outlets.photos as outlet_picture'
            , 'admin.name as fo_name'
            , 'visit_pictures.branding_pictures as new_branding_pictures'
            , 'visit_pictures.one_pictures as new_one_pictures')
            ->leftjoin('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->leftjoin('admin', 'admin.id', '=', 'outlets.admin_id')
            ->leftjoin('visit_pictures', 'visit_pictures.visit_id', '=', 'visits.id')
      ->where(function ($q) {
                $q->where('visit_pictures.branding_pictures', '!=', '[]')
                    ->orWhere('visit_pictures.one_pictures', '!=', '[]');
            })

            ->where('visit_pictures.branding_pictures', '!=', '[]')
            ->where('visit_pictures.branding_pictures', '!=', '')
            //->orWhere('visits.one_pictures', '!=', '[]')
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
            $query->where('outlets.admin_id', '=', $fo_id);
        }

        return $query->get();
    }

//
//    function count_oos_tracking() {
//
//        $query = $visits->query("SELECT bcc_oos_tracking . id
//                                    FROM  `bcc_oos_tracking`
//                                    JOIN bcc_outlets ON bcc_oos_tracking.outlet_id = bcc_outlets.id
//                                    JOIN bcc_products ON bcc_oos_tracking.product_id = bcc_products.id
//                                    WHERE bcc_outlets.active =1
//                                    AND bcc_oos_tracking.date < ( NOW( ) - INTERVAL 4 DAY )");
//        return $query->num_rows();
//    }
    // Tracking Visited outlet Report
    public function get_tracking_visited_data($start_date, $end_date, $merch_id)
    {

        $query = Visit::select('outlets.name as outlet_name'
            , 'outlets.state as state_name'
            , 'outlets.zone as zone_name'
            , 'admin.name as hfo'
            , 'visits.date as date')
            ->from('visits')
            ->join('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->join('admin', 'admin.id', '=', 'outlets.admin_id')
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date);

        if ($merch_id != -1) {
            $query->where('admin.id', $merch_id);
        }

        $query->whereIn('visits.monthly_visit', array('1', '3'))
            ->where('outlets.active', 1)
            ->groupBy('visits.outlet_id')
            ->orderBy('visits.date', 'DESC');

        return $query->get();
    }

// Tracking unvisited outlet Report
    public function get_tracking_unvisited_data($start_date, $end_date, $merch_id)
    {
// Sub Query
//        $query1 = Visit::select('visits.outlet_id')
//                ->where('visits.m_date >=', $start_date)
//                ->where('visits.m_date <= ', $end_date)
//                ->whereIn('visits.monthly_visit', array('1', '3'))
//                ->from('visits')
//                ->get();

        $query2 = Outlet::select('outlets.name as outlet_name'
            , 'outlets.state as state_name'
            , 'outlets.zone as zone_name'
            , 'admin.name as hfo')
            ->join('admin', 'admin.id', '=', 'outlets.admin_id')
            ->where('outlets.active', 1);

        if ($merch_id != -1) {
            $query2->where('admin.id', $merch_id);
        }
//        ->where("cos_outlets.id NOT IN ($query1)", NULL, FALSE)
        $query2->whereNotIn('outlets.id', DB::table('visits')
            ->where('visits.date', '>=', $start_date)
            ->where('visits.date', '<=', $end_date)
            ->whereIn('visits.monthly_visit', array('1', '3'))
            ->pluck('visits.outlet_id'));

        return $query2->get();
    }

}
