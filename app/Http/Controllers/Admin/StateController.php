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
use App\Repositories\StateRepository;
use App\Repositories\ZoneRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class StateController extends Controller {

    protected $stateRepository;
    protected $zoneRepository;

    public function __construct(StateRepository $stateRepository, ZoneRepository $zoneRepository) {
 parent::__construct();
        $this->stateRepository = $stateRepository;
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = 'state';
        $subTitle = 'List of States';
        return view('admin.states.index', compact('title', 'subTitle'));
    }

    public function getStates(Request $request) {
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
        $states = $this->stateRepository->getAjaxStates($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($states);
    }

    public function create() {
        $title = 'state';
        $subTitle = 'Creat State';

        $zones = $this->zoneRepository->listZones(['id', 'name']);
        $zones = $zones->pluck('name', 'id');
        return view('admin.states.create', compact('title', 'subTitle', 'zones'));
    }

    public function edit($id) {
        $title = 'state';
        $subTitle = 'Edit State';
        $state = $this->stateRepository->getStateById($id);

        $zones = $this->zoneRepository->listZones(['id', 'name']);
        $zones = $zones->pluck('name', 'id');
        $zones->prepend($state->Zone->name, $state->Zone->id);

        return view('admin.states.edit', compact('title', 'subTitle', 'state', 'zones'));
    }

    public function postState(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'code' => 'required|numeric',
        ]);

        if ($request->input('id'))
            $state_id = $request->input('id');
        else {
            $this->validate($request, [
                'name' => '|unique:states,name',
                'code' => 'unique:states,code',
            ]);
            $state_id = '';
        }

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['zone_id'] = $request->input('zone_id');


        $id_state_inserted = $this->stateRepository->addState($save, $state_id);

        // Store data for only a single request and destory
        request()->session()->flash('message', 'State has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.state.index');
    }

    public function delete($id) {
        $this->stateRepository->deleteState($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'State has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.state.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->stateRepository->addState($save, $id);
        request()->session()->flash('message', 'state has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.state.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->stateRepository->addState($save, $id);
        request()->session()->flash('message', 'state has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.state.index');
    }

}
