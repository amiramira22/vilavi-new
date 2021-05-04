<?php

//pharmacie

namespace App\Repositories;

use App\Entities\State;
use DB;

class StateRepository extends ResourceRepository {

    public function __construct(State $state) {
        $this->model = $state;
    }

    public function countStates($search = '-1') {
        if ($search == '-1') {
            return State::count();
        } else {
            return State::leftjoin('zones', 'states.zone_id', '=', 'zones.id')
                            ->where('states.code', 'like', "%{$search}%")
                            ->orWhere('states.name', 'like', "%{$search}%")
                            ->orWhere('zones.name', 'like', "%{$search}%")
                            ->count();
        }
        return State::count();
    }

    public function getAjaxStates($start = 0, $limit = 0, $order = 'states.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $states = State::select('states.*', 'zones.name as zone_name')
                ->leftjoin('zones', 'states.zone_id', '=', 'zones.id');

        if ($search != '-1') {
            $states->where('states.code', 'like', "%{$search}%");
            $states->orWhere('states.name', 'like', "%{$search}%");
            $states->orWhere('zones.name', 'like', "%{$search}%");
        }

        $states->offset($start);
        $states->limit($limit);
        $states->orderBy($order, $dir);
        $states = $states->get();

        // Total sales rows
        $totalData = $this->countStates($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($states) {
            foreach ($states as $c) {
                $nestedData['code'] = $c->code;
                $nestedData['state'] = $c->name;
                $nestedData['zone'] = $c->zone_name;
                $nestedData['status'] = $c->active;

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="state/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="state/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this state ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="state/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="state/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="state/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this state ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="state/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
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

    public function listStates() {

        $states = State::select('states.*')
                ->orderBy('code')
                ->get();
        return $states;
    }

    public function getStates($search) {

        $states = State::select('states.*')
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('code')
                ->paginate(20);
        //set the value of the search
        $states->appends(['search' => $search]);
        //  dd($products);
        return $states;
    }

    public function addState($save, $id = '') {

        if ($id == '') {
            $id = DB::table('states')->insertGetId(
                    $save
            );
        } else {
            DB::table('states')
                    ->where('states.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteState($id) {

        DB::table('states')->where('states.id', $id)->delete();
    }

    public function getStateById($id) {

        $state = State::select('states.*')
                ->where('states.id', $id)
                ->first();
        //dd($state);
        return $state;
    }

}
