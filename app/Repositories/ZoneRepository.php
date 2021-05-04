<?php

namespace App\Repositories;

use App\Entities\Zone;
use DB;

class ZoneRepository extends ResourceRepository {

    public function __construct(Zone $zone) {
        $this->model = $zone;
    }

    public function countZones($search = '-1') {
        if ($search == '-1') {
            return Zone::count();
        } else {
            return Zone::where('zones.code', 'like', "%{$search}%")
                            ->orWhere('zones.name', 'like', "%{$search}%")
                            ->count();
        }
        return Zone::count();
    }

    public function listZones() {

        $zones = Zone::select('zones.*')
                ->orderBy('code')
                ->get();
        return $zones;
    }

    public function getAjaxZones($start = 0, $limit = 0, $order = 'zones.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $zones = Zone::select('zones.*');
        if ($search != '-1') {
            $zones->where('zones.code', 'like', "%{$search}%");
            $zones->orWhere('zones.name', 'like', "%{$search}%");
        }

        $zones->offset($start);
        $zones->limit($limit);
        $zones->orderBy($order, $dir);
        $zones = $zones->get();

        // Total sales rows
        $totalData = $this->countZones($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($zones) {

            foreach ($zones as $c) {

                $nestedData['code'] = $c->code;
                $nestedData['zone'] = $c->name;

                $nestedData['color'] = '<style>
                .m-badge.m-badge--color' . $c->id . ' {
                background-color:' . $c->color . ' !important;
                color: #fff;
                }
                </style > <span class="m-badge m-badge--color' . $c->id . '"></span>';

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="zone/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="zone/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this zone ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="zone/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="zone/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="zone/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this zone ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="zone/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
                                <i class="fa fa-thumbs-up"></i>				
                            </a>
                          
                        </span>';
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

    public function getZones($search = '') {

        $zones = Zone::select('zones.*')
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('code')
                ->paginate(20);
        //set the value of the search
        $zones->appends(['search' => $search]);
        //  dd($zones);
        return $zones;
    }

    public function addZone($save, $id = '') {

        if ($id == '') {
            $id = DB::table('zones')->insertGetId(
                    $save
            );
        } else {
            DB::table('zones')
                    ->where('zones.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteZone($id) {

        DB::table('zones')->where('zones.id', $id)->delete();
    }

    public function getZoneById($id) {

        $zone = Zone::select('zones.*')
                ->where('zones.id', $id)
                ->first();
        //dd($zone);
        return $zone;
    }

}
