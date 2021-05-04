<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;
use DB;
use App\Entities\User;
use App\Entities\Channel;
use App\Entities\Zone;
use App\Entities\Outlet;
use App\Entities\Product;
use App\Repositories\StateRepository;
use App\Repositories\ZoneRepository;
use App\Repositories\ChannelRepository;
use App\Repositories\SubChannelRepository;
use App\Repositories\UserRepository;
use App\Repositories\OutletRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use FarhanWazir\GoogleMaps\GMaps;

class OutletController extends Controller {

    protected $gmap;
    protected $stateRepository;
    protected $channelRepository;
    protected $subChannelRepository;
    protected $zoneRepository;
    protected $userRepository;
    protected $outletRepository;

    public function __construct(ChannelRepository $channelRepository, SubChannelRepository $subChannelRepository, ZoneRepository $zoneRepository, UserRepository $userRepository, OutletRepository $outletRepository, StateRepository $stateRepository, GMaps $gmap) {
        parent::__construct();
        $this->channelRepository = $channelRepository;
        $this->subChannelRepository = $subChannelRepository;
        $this->zoneRepository = $zoneRepository;
        $this->userRepository = $userRepository;
        $this->outletRepository = $outletRepository;
        $this->stateRepository = $stateRepository;
        $this->gmap = $gmap;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $title = 'Outlet';
        $subTitle = 'List of Outlet';
        return view('admin.outlet.index', compact('title', 'subTitle'));
    }

    function view($id) {

        $title = 'Outlets';
        $subTitle = 'Outlet Position';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $outlet = $this->outletRepository->getOutletById($id);
        
        $data['outlet'] = $outlet;
          $data['created'] = Outlet::select(DB::raw('CAST(bcc_outlets.updated as DATE) as created_date'))
                ->first();
        $config['center'] = $outlet->latitude . ',' . $outlet->longitude;
        $config['zoom'] = '13';
        $config['styles'] = array(array("name" => "Red Parks", "definition" => array(array("featureType" => "all", "stylers" => array(array("saturation" => "-30"))), array("featureType" => "poi.park", "stylers" => array(array("saturation" => "10"), array("hue" => "#990000"))))), array("name" => "Black Roads", "definition" => array(array("featureType" => "all", "stylers" => array(array("saturation" => "-70"))), array("featureType" => "road.arterial", "elementType" => "geometry", "stylers" => array(array("hue" => "#000000"))))), array("name" => "No Businesses", "definition" => array(array("featureType" => "poi.business", "elementType" => "labels", "stylers" => array(array("visibility" => "off"))))));
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $config['https'] = true;
        $this->gmap->initialize($config);
        $marker = array();
        $content = $outlet->name;
        $marker['infowindow_content'] = $content;
        $marker['icon'] = url('assets/img/ic_map_red.png');
        $marker['position'] = $outlet->latitude . ',' . $outlet->longitude;
        $this->gmap->add_marker($marker);
        $data['map'] = $this->gmap->create_map();


        $store_album_report = $this->outletRepository->get_store_album_data($id);
        //dd($store_album_report);
        $data['album'] = $store_album_report;
        


        return view('admin.outlet.view', $data);
    }

    public function getOutlets(Request $request) {

        $columns = array(
            0 => 'outlets.id',
            1 => 'outlets.created',
            2 => 'outlets.code',
            3 => 'outlets.name',
            4 => 'channels.name',
            5 => 'sub_channels.name',
            6 => 'states.name',
            7 => 'zones.name',
            8 => 'users.name',
            9 => 'outlets.adress',
            10 => 'outlets.active',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $draw = $request->input('draw');
        $search = $request->input('search.value');

        if (empty($search)) {
            $search = '-1';
        } else {
            $search = $request->input('search.value');
        }

        $outlets = $this->outletRepository->getAjaxOutlets($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($outlets);
    }

    public function ha_outlets() {

        $title = 'HA Products';
        $subTitle = 'HA Products';
        return view('admin.outlet.ha_outlets', compact('title', 'subTitle'));
    }

    public function getOutletsForHaProducts(Request $request) {

        $columns = array(
            0 => 'outlets.created',
            1 => 'outlets.code',
            2 => 'outlets.name',
            3 => 'channels.name',
            4 => 'sub_channels.name',
            5 => 'states.name',
            6 => 'zones.name',
            7 => 'users.name',
            8 => 'outlets.active',
        );

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $draw = $request->input('draw');
        $search = $request->input('search.value');

        if (empty($search)) {
            $search = '-1';
        } else {
            $search = $request->input('search.value');
        }

        $outlets = $this->outletRepository->getOutletsForHaProducts($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($outlets);
    }

    public function create() {
        $title = 'Outlet';
        $subTitle = 'Creat outlet';

        $states = $this->stateRepository->listStates(['id', 'name']);
        $states = $states->pluck('name', 'id');

        $zones = $this->zoneRepository->listZones(['id', 'name']);
        $zones = $zones->pluck('name', 'id');

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');

        $subChannels = $this->subChannelRepository->listSubChannels(['id', 'name']);
        $subChannels = $subChannels->pluck('name', 'id');

        $users = $this->userRepository->getUsersByRole('Field Officer');
        $users = $users->pluck('name', 'id');

        return view('admin.outlet.create', compact('title', 'subTitle', 'states', 'zones', 'channels', 'subChannels', 'users'));
    }

    public function edit($id) {
        $title = 'Outlet';
        $subTitle = 'Edit outlet';

        $outlet = $this->outletRepository->getOutletById($id);
        $visit_days = json_decode($outlet->visit_day, true);


//dd($outlet);
        $states = $this->stateRepository->listStates(['id', 'name']);
        $states = $states->pluck('name', 'id');
        $states->prepend($outlet->outletState->name, $outlet->outletState->id);

        $zones = $this->zoneRepository->listZones(['id', 'name']);
        $zones = $zones->pluck('name', 'id');
        $zones->prepend($outlet->outletZone->name, $outlet->outletZone->id);

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        $channels->prepend($outlet->outletChannel->name, $outlet->outletChannel->id);

        $subChannels = $this->subChannelRepository->listSubChannels(['id', 'name']);
        $subChannels = $subChannels->pluck('name', 'id');
        $subChannels->prepend($outlet->outletSubChannel->name, $outlet->outletSubChannel->id);

        $users = $this->userRepository->getUsersByRole('Field Officer');
        $users = $users->pluck('name', 'id');
        $users->prepend($outlet->outletUser->name, $outlet->outletUser->id);
//dd('test');
        return view('admin.outlet.edit', compact('title', 'subTitle', 'outlet', 'states', 'zones', 'channels', 'subChannels', 'users', 'visit_days'));
    }

    public function postOutlet(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        if ($request->input('id'))
            $outlet_id = $request->input('id');
        else
            $outlet_id = '';

//        $save['code'] = $request->input('code');
        $save['name'] = $request->input('name');
        $save['state_id'] = $request->input('state_id');
        $save['zone_id'] = $request->input('zone_id');
        $save['channel_id'] = $request->input('channel_id');
        $save['sub_channel_id'] = $request->input('sub_channel_id');
        $save['adress'] = $request->input('adress');
        $save['contact'] = $request->input('phone');
        $save['contact_pdv'] = $request->input('contact');
        $save['admin_id'] = $request->input('fo_id');

        $save['delivery_day'] = $request->input('delivery_day');
        $save['longitude'] = $request->input('longitude');
        $save['latitude'] = $request->input('latitude');
        $save['visit_day'] = json_encode($request->input('visit_day'));
        //dd($save['visit_day']);
        if ($request->photo) {
            $photo = $request->photo;
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path('outlet'), $filename);
            $save['photos'] = $filename;
        }
        $id_outlet_inserted = $this->outletRepository->addOutlet($save, $outlet_id);
        //dd($id_outlet_inserted);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Outlet has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.outlet.index');
    }

    public function delete($id) {
        $this->outletRepository->deleteOutlet($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Outlet has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.outlet.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->outletRepository->addOutlet($save, $id);
        request()->session()->flash('message', 'outlet has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.outlet.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->outletRepository->addOutlet($save, $id);
//        $this->outletRepository->update($id, $save);
        request()->session()->flash('message', 'outlet has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.outlet.index');
    }

    public function geolocalisation() {

        $title = 'Outlets';
        $subTitle = 'Geolocalisation';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        $data['outlets'] = Outlet::get();
        $data['channels'] = Channel::where('active', 1)->get();

//dd($data['outlets']);
        return view('admin.outlet.geolocalisation', $data);
    }

}
