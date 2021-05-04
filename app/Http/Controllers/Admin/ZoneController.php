<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Repositories\ZoneRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class ZoneController extends Controller {

    protected $zoneRepository;

    public function __construct(ZoneRepository $zoneRepository) {
 parent::__construct();
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = 'zone';
        $subTitle = 'List of Zones';
        return view('admin.zones.index', compact('title', 'subTitle'));
    }

    public function getZones(Request $request) {
        $columns = array(
            0 => 'code',
            1 => 'name',
            2 => 'active'
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
        $zones = $this->zoneRepository->getAjaxZones($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($zones);
    }

    public function create() {
        $title = 'zone';
        $subTitle = 'Creat Zone';
        return view('admin.zones.create', compact('title', 'subTitle'));
    }

    public function edit($id) {
        $title = 'zone';
        $subTitle = 'Edit Zone';
        $zone = $this->zoneRepository->getZoneById($id);
        return view('admin.zones.edit', compact('title', 'subTitle', 'zone'));
    }

    public function postZone(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'color' => 'required',
            'code' => 'required|numeric',
        ]);

        if ($request->input('id'))
            $zone_id = $request->input('id');
        else {
            $this->validate($request, [
                'name' => '|unique:zones,name',
                'color' => 'unique:zones,color',
                'code' => 'unique:zones,code',
            ]);
            $zone_id = '';
        }

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['color'] = $request->input('color');


        $id_zone_inserted = $this->zoneRepository->addZone($save, $zone_id);

        // Store data for only a single request and destory
        request()->session()->flash('message', 'Zone has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.zone.index');
    }

    public function delete($id) {
        $this->zoneRepository->deleteZone($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Zone has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.zone.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->zoneRepository->addZone($save, $id);
        request()->session()->flash('message', 'zone has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.zone.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->zoneRepository->addZone($save, $id);
        request()->session()->flash('message', 'zone has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.zone.index');
    }

}
