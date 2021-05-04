<?php

//pharmacie

namespace App\Repositories;

use App\Entities\Outlet;
use DB;

class OutletRepository extends ResourceRepository
{

    public function __construct(Outlet $outlet)
    {
        $this->model = $outlet;
    }

    public function countOutlets($search = '-1')
    {
        if ($search == '-1') {
            return Outlet::count();
        } else {
            return Outlet::leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
                ->leftjoin('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
                ->leftjoin('channels', 'sub_channels.channel_id', '=', 'channels.id')
//                            ->leftjoin('channels', 'outlets.channel_id', '=', 'channels.id')
                ->leftjoin('states', 'outlets.state_id', '=', 'states.id')
                ->leftjoin('admin', 'outlets.admin_id', '=', 'admin.id')
                ->where('outlets.code', 'like', "%{$search}%")
                ->orWhere('outlets.name', 'like', "%{$search}%")
                ->orWhere('outlets.adress', 'like', "%{$search}%")
                ->orWhere('states.name', 'like', "%{$search}%")
                ->orWhere('channels.name', 'like', "%{$search}%")
                ->orWhere('sub_channels.name', 'like', "%{$search}%")
                ->orWhere('zones.name', 'like', "%{$search}%")
                ->orWhere('admin.name', 'like', "%{$search}%")
                ->count();
        }
        return Outlet::count();
    }

    public function countActiveOutlets($search = '-1')
    {
        if ($search == '-1') {
            return Outlet::where('outlets.active', '=', 1)->count();
        } else {
            return Outlet::leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
                ->leftjoin('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
                ->leftjoin('channels', 'sub_channels.channel_id', '=', 'channels.id')
//                            ->leftjoin('channels', 'outlets.channel_id', '=', 'channels.id')
                ->leftjoin('states', 'outlets.state_id', '=', 'states.id')
                ->leftjoin('admin', 'outlets.admin_id', '=', 'admin.id')
                ->where('outlets.active', '=', 1)
                ->where('outlets.code', 'like', "%{$search}%")
                ->orWhere('outlets.name', 'like', "%{$search}%")
                ->orWhere('states.name', 'like', "%{$search}%")
                ->orWhere('channels.name', 'like', "%{$search}%")
                ->orWhere('sub_channels.name', 'like', "%{$search}%")
                ->orWhere('zones.name', 'like', "%{$search}%")
                ->orWhere('admin.name', 'like', "%{$search}%")
                ->count();
        }
        return Outlet::count();
    }

    public function getAjaxOutlets($start = 0, $limit = 0, $order = 'outlets.id', $dir = 'DESC', $draw = 0, $search = '-1')
    {

        // get sales filtred rows
        $outlets = Outlet::select('outlets.*'
            , 'channels.name as channel'
            , 'zones.name as zone'
            , 'sub_channels.name as sub_channel'
            , 'states.name as state'
            , 'admin.name as user'
            , DB::raw('CAST(bcc_outlets.updated as DATE) as created_date'))
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->leftjoin('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
            ->leftjoin('channels', 'sub_channels.channel_id', '=', 'channels.id')
//              ->leftjoin('channels', 'outlets.channel_id', '=', 'channels.id')
            ->leftjoin('states', 'outlets.state_id', '=', 'states.id')
            ->leftjoin('admin', 'outlets.admin_id', '=', 'admin.id');

        if ($search != '-1') {
            $outlets->where('outlets.code', 'like', "%{$search}%");
            $outlets->orWhere('outlets.name', 'like', "%{$search}%");
            $outlets->orWhere('outlets.adress', 'like', "%{$search}%");
            $outlets->orWhere('states.name', 'like', "%{$search}%");
            $outlets->orWhere('channels.name', 'like', "%{$search}%");
            $outlets->orWhere('sub_channels.name', 'like', "%{$search}%");
            $outlets->orWhere('zones.name', 'like', "%{$search}%");
            $outlets->orWhere('admin.name', 'like', "%{$search}%");
        }
        if (request()->session()->get('connected_user_acces') == 'Henkel') {
            $outlets->where('outlets.active', 1);
        }
            $outlets->offset($start);
        $outlets->limit($limit);
        $outlets->orderBy($order, $dir);
        $outlets = $outlets->get();

        // Total sales rows
        $totalData = $this->countOutlets($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($outlets) {
            foreach ($outlets as $c) {
                if (isset($c->photos))
                    $image = $c->photos;
                else
                    $image = 'introuvable.png';
                //$nestedData['image'] = '<img src="../public/products_photo/$c->filename" alt="" class="responsive-img left" height="50" width="50" alt="current">';
                $nestedData['image'] = "<img src='https://hcm.capesolution.tn/uploads/outlet/" . $image . "'  class='responsive-img left' height='50' width='50' alt='current'>";


                $nestedData['code'] = $c->code;
                $nestedData['created'] = reverse_format($c->created_date);
                $nestedData['outlet'] = $c->name;
                $nestedData['state'] = $c->state;
                $nestedData['zone'] = $c->zone;
                $nestedData['channel'] = $c->channel;
                $nestedData['sub_channel'] = $c->sub_channel;
                $nestedData['fo_name'] = $c->user;
                $nestedData['adresse'] = $c->adress;


                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '
                        
                      <span class="dropdown">

                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="fas fa-ellipsis-h"></i>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right">
                         					
                            <a href="outlet/edit/' . $c->id . '"  class="dropdown-item" title="Edit details">	
                                <i class="fas fa-edit"></i> Edit			
                            </a>						
                            <a href="outlet/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this outlet ?\')" class="dropdown-item" title="Delete">	
                                <i class="fas fa-trash"></i> Delete				
                            </a>
                            <a href="outlet/desactivate/' . $c->id . '"  class="dropdown-item" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i> Desactivate	 			
                            </a>
                        
                            <a href="outlet/view/' . $c->id . '"  class="dropdown-item" title="view">	
                                <i class="flaticon-map-location"></i> View	 			
                            </a>

                        </div>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '
                         <span class="dropdown">

                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                        <i class="fas fa-ellipsis-h"></i>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right">                        

               					
                            <a href="outlet/edit/' . $c->id . '"  class="dropdown-item" title="Edit details">	
                                <i class="fas fa-edit"></i> Edit				
                            </a>						
                            <a href="outlet/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this outlet ?\')" class="dropdown-item" title="Delete">	
                                <i class="fas fa-trash"></i> Delete				
                            </a>
                            <a href="outlet/activate/' . $c->id . '"  class="dropdown-item" title="activate">	
                                <i class="fa fa-thumbs-up"></i>	Activate			
                            </a>
                            
                            <a href="outlet/view/' . $c->id . '"  class="dropdown-item" title="view">	
                                <i class="flaticon-map-location"></i> View	 			
                            </a>
                        </div>
                        </span>';
                }
                $data[] = $nestedData;
            }
            //dd($data[]);
        }

        return array(
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
    }

    public function getOutletsForHaProducts($start = 0, $limit = 0, $order = 'outlets.id', $dir = 'DESC', $draw = 0, $search = '-1')
    {

        // get sales filtred rows
        $outlets = Outlet::select('outlets.*',
            'outlets.id as outlet_id'
            , 'channels.name as channel'
            , 'zones.name as zone'
            , 'sub_channels.name as sub_channel'
            , 'states.name as state'
            , 'admin.name as user'
            , DB::raw('CAST(bcc_outlets.updated as DATE) as created_date'))
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->leftjoin('sub_channels', 'outlets.sub_channel_id', '=', 'sub_channels.id')
            ->leftjoin('channels', 'sub_channels.channel_id', '=', 'channels.id')
//              ->leftjoin('channels', 'outlets.channel_id', '=', 'channels.id')
            ->leftjoin('states', 'outlets.state_id', '=', 'states.id')
            ->leftjoin('admin', 'outlets.admin_id', '=', 'admin.id')
            ->where('outlets.active', '=', 1);


        if ($search != '-1') {
            $outlets->where('outlets.code', 'like', "%{$search}%");
            $outlets->orWhere('outlets.name', 'like', "%{$search}%");
            $outlets->orWhere('states.name', 'like', "%{$search}%");
            $outlets->orWhere('channels.name', 'like', "%{$search}%");
            $outlets->orWhere('sub_channels.name', 'like', "%{$search}%");
            $outlets->orWhere('zones.name', 'like', "%{$search}%");
            $outlets->orWhere('admin.name', 'like', "%{$search}%");
        }

        if ($order == 'outlets.created')
            $order = 'outlets.updated';
        $outlets->offset($start);
        $outlets->limit($limit);
        $outlets->orderBy($order, $dir);
        $outlets = $outlets->get();

        // Total sales rows
        $totalData = $this->countActiveOutlets($search);
        $totalFiltered = $totalData;

        $data = array();
        if ($outlets) {
            foreach ($outlets as $c) {
                $nestedData['code'] = $c->code;
                $nestedData['created'] = reverse_format($c->created_date);
                $nestedData['outlet'] = $c->name;
                $nestedData['state'] = $c->state;
                $nestedData['zone'] = $c->zone;
                $nestedData['channel'] = $c->channel;
                $nestedData['sub_channel'] = $c->sub_channel;
                $nestedData['fo_name'] = $c->user;
                $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
//                ../product/ha_products/' . $c->id . '
                $outlet_id = $c->outlet_id;


                //$nestedData['ha_products'] = "<a href='/admin/product/ha_products/'" . $outlet_id . " title='HA Products'>
                $nestedData['ha_products'] = "<a href=\"/admin/product/ha_products/$outlet_id\" title='HA Products' target='_blank'>	
                               <i class='flaticon-list-3'></i> Show			
                            </a>";
                $data[] = $nestedData;
            }
            //dd($data[]);
        }

        return array(
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
    }

    public function listOutlets()
    {

        $outlets = Outlet::select('outlets.*')
            ->orderBy('code')
            ->get();
        return $outlets;
    }

    public function getOutlets($search)
    {

        $outlets = Outlet::select('outlets.*')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('code')
            ->paginate(20);
        //set the value of the search
        $outlets->appends(['search' => $search]);
        //  dd($products);
        return $outlets;
    }

    public function getActiveOutlets()
    {

        $outlets = Outlet::select('outlets.*')
            ->where('active', '=', 1)
            ->orderBy('code')
            ->paginate(20);

        return $outlets;
    }

    public function addOutlet($save, $id = '')
    {

        if ($id == '') {
            $id = DB::table('outlets')->insertGetId(
                $save
            );
            $code['code'] = 'BVM' . $id;

            DB::table('outlets')
                ->where('outlets.id', $id)
                ->update($code);
        } else {
            DB::table('outlets')
                ->where('outlets.id', $id)
                ->update($save);
        }
        return $id;
    }

    public function deleteOutlet($id)
    {

        DB::table('outlets')->where('outlets.id', $id)->delete();
    }

    public function getOutletById($id)
    {

        $outlet = Outlet::select('outlets.*')
            ->where('outlets.id', $id)
            ->first();
        //dd($outlet);
        return $outlet;
    }

    public function getOutletByZoneChannel($zone_id, $channel_id)
    {
        $outlets = Outlet::select('outlets.*')
            ->leftjoin('channels', 'outlets.channel_id', '=', 'channels.id')
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->distinct()
            ->orderBy('outlets.name', 'ASC');

        if ($zone_id != -1) {
            $outlets->where('zones.id', $zone_id);
        }

        if ($channel_id != -1) {
            $outlets->where('channels.id', $channel_id);
        }
        return $outlets->get();
    }

    public function getOutletByZoneFo($zone_id, $fo_id)
    {
        $outlets = Outlet::select('outlets.*')
            ->leftjoin('admin', 'outlets.admin_id', '=', 'admin.id')
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->distinct()
            ->orderBy('outlets.name', 'ASC');

        if ($zone_id != -1) {
            $outlets->where('zones.id', $zone_id);
        }

        if ($fo_id != -1) {
            $outlets->where('admin.id', $fo_id);
        }
        return $outlets->get();
    }

    function get_store_album_data($outlet_id)
    {

        $query = DB::table('visits')->select('outlets.id as outlet_id'
            , 'outlets.name as outlet_name'
            , 'zones.name as zone_name'
            , 'outlets.photos as outlet_picture'
            , 'admin.name as fo_name'
            , 'visits.one_pictures as one_pictures'
            , DB::raw('MAX(bcc_visits.date) as date'))
            ->leftjoin('outlets', 'visits.outlet_id', '=', 'outlets.id')
            ->leftjoin('zones', 'outlets.zone_id', '=', 'zones.id')
            ->leftjoin('admin', 'admin.id', '=', 'outlets.admin_id')
            ->where('visits.one_pictures', '!=', '[]')
//                ->groupBy('outlets.id')
            ->orderBy('date', 'desc')
            ->orderBy('visits.id', 'desc')
            ->distinct()
            ->where('outlets.id', '=', $outlet_id);
        return $query->get();
    }

//    public function getoutletById($id) {
//
//        $outlet = Outlet::select('outlets.*')
//                ->where('outlets.id', $id)
//                ->first();
//        //dd($visit);
//        return $outlet;
//    }
}
