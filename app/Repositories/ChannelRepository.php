<?php

namespace App\Repositories;

use App\Entities\Channel;
use DB;

class ChannelRepository extends ResourceRepository {

    public function __construct(Channel $channel) {
        $this->model = $channel;
    }

    public function countChannels($search = '-1') {
        if ($search == '-1') {
            return Channel::count();
        } else {
            return Channel::where('channels.code', 'like', "%{$search}%")
                            ->orWhere('channels.name', 'like', "%{$search}%")
                            ->count();
        }
        return Channel::count();
    }

    public function getAjaxChannels($start = 0, $limit = 0, $order = 'channels.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $channels = Channel::select('channels.*');
        if ($search != '-1') {
            $channels->where('channels.code', 'like', "%{$search}%");
            $channels->orWhere('channels.name', 'like', "%{$search}%");
        }

        $channels->offset($start);
        $channels->limit($limit);
        $channels->orderBy($order, $dir);
        $channels = $channels->get();

        // Total sales rows
        $totalData = $this->countChannels($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($channels) {

            foreach ($channels as $c) {

                $nestedData['code'] = $c->code;
                $nestedData['channel'] = $c->name;

                $nestedData['color'] = '<style>
                .m-badge.m-badge--color' . $c->id . ' {
                background-color:' . $c->color . ' !important;
                color: #fff;
                }
                </style > <span class="m-badge m-badge--color' . $c->id . '"></span>';

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="channel/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="channel/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this channel ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="channel/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="channel/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="channel/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this channel ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="channel/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
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

    public function getChannels($search = '') {

        $channels = Channel::select('channels.*')
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('code')
                ->paginate(20);
        //set the value of the search
        $channels->appends(['search' => $search]);
        //  dd($channels);
        return $channels;
    }

    public function listChannels() {

        $channels = Channel::select('channels.*')
                ->where('active', 1)
                ->orderBy('code')
                ->get();
        return $channels;
    }

    public function addChannel($save, $id = '') {

        if ($id == '') {
            $id = DB::table('channels')->insertGetId(
                    $save
            );
        } else {
            DB::table('channels')
                    ->where('channels.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteChannel($id) {

        DB::table('channels')->where('channels.id', $id)->delete();
    }

    public function getChannelById($id) {

        $channel = Channel::select('channels.*')
                ->where('channels.id', $id)
                ->first();
        //dd($channel);
        return $channel;
    }

}
