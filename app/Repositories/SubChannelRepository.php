<?php

//pharmacie

namespace App\Repositories;

use App\Entities\SubChannel;
use DB;

class SubChannelRepository extends ResourceRepository {

    public function __construct(SubChannel $subChannel) {
        $this->model = $subChannel;
    }

    public function countSubChannels($search = '-1') {
        if ($search == '-1') {
            return SubChannel::count();
        } else {
            return SubChannel::leftjoin('channels', 'sub_channels.channel_id', '=', 'channels.id')
                            ->where('sub_channels.code', 'like', "%{$search}%")
                            ->orWhere('sub_channels.name', 'like', "%{$search}%")
                            ->orWhere('channels.name', 'like', "%{$search}%")
                            ->count();
        }
        return SubChannel::count();
    }

    public function getAjaxSubChannels($start = 0, $limit = 0, $order = 'sub_channels.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $sub_channels = SubChannel::select('sub_channels.*', 'channels.name as channel_name')
                ->leftjoin('channels', 'sub_channels.channel_id', '=', 'channels.id');

        if ($search != '-1') {
            $sub_channels->where('sub_channels.code', 'like', "%{$search}%");
            $sub_channels->orWhere('sub_channels.name', 'like', "%{$search}%");
            $sub_channels->orWhere('channels.name', 'like', "%{$search}%");
        }

        $sub_channels->offset($start);
        $sub_channels->limit($limit);
        $sub_channels->orderBy($order, $dir);
        $sub_channels = $sub_channels->get();

        // Total sales rows
        $totalData = $this->countSubChannels($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($sub_channels) {
            foreach ($sub_channels as $c) {
                $nestedData['code'] = $c->code;
                $nestedData['sub_channel'] = $c->name;
                $nestedData['channel'] = $c->channel_name;
                $nestedData['status'] = $c->active;

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="sub_channel/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="sub_channel/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this sub channel ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="sub_channel/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="sub_channel/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="sub_channel/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this sub channel ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="sub_channel/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
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

    public function listSubChannels() {

        $subCategories = SubChannel::select('sub_channels.*')
                ->orderBy('code')
                ->get();
        return $subCategories;
    }

    public function getSubChannels($search) {

        $subCategories = SubChannel::select('sub_channels.*')
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('code')
                ->paginate(20);
        //set the value of the search
        $subCategories->appends(['search' => $search]);
        //  dd($products);
        return $subCategories;
    }

    public function addSubChannel($save, $id = '') {

        if ($id == '') {
            $id = DB::table('sub_channels')->insertGetId(
                    $save
            );
        } else {
            DB::table('sub_channels')
                    ->where('sub_channels.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteSubChannel($id) {

        DB::table('sub_channels')->where('sub_channels.id', $id)->delete();
    }

    public function getSubChannelById($id) {

        $subChannel = SubChannel::select('sub_channels.*')
                ->where('sub_channels.id', $id)
                ->first();
        //dd($subChannel);
        return $subChannel;
    }

}
