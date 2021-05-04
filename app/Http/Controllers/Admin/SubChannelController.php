<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadRequest;
use App\Repositories\ChannelRepository;
use App\Repositories\SubChannelRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class SubChannelController extends Controller {

    protected $channelRepository;
    protected $subChannelRepository;

    public function __construct(ChannelRepository $channelRepository, SubChannelRepository $subChannelRepository) {
 parent::__construct();
        $this->channelRepository = $channelRepository;
        $this->subChannelRepository = $subChannelRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $title = 'Sub Channels';
        $subTitle = 'List of Sub Channels';
        return view('admin.sub_channel.index', compact('title', 'subTitle'));
    }

    public function getSubChannels(Request $request) {

        $columns = array(
            0 => 'code',
            1 => 'name',
            2 => 'channels.name',
            3 => 'active'
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

        $sub_channels = $this->subChannelRepository->getAjaxSubChannels($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($sub_channels);
    }

    public function create() {
        $title = 'Sub Channels';
        $subTitle = 'Creat sub Channel';

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        return view('admin.sub_channel.create', compact('title', 'subTitle', 'channels'));
    }

    public function edit($id) {
        $title = 'Sub Channels';
        $subTitle = 'Edit sub Channel';
        $subChannel = $this->subChannelRepository->getSubChannelById($id);

        $channels = $this->channelRepository->listChannels(['id', 'name']);
        $channels = $channels->pluck('name', 'id');
        $channels->prepend($subChannel->channel->name, $subChannel->channel->id);
        return view('admin.sub_channel.edit', compact('title', 'subTitle', 'subChannel', 'channels'));
    }

    public function postSubChannel(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        if ($request->input('id'))
            $sub_channel_id = $request->input('id');
        else
            $sub_channel_id = '';

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['channel_id'] = $request->input('channel_id');

        $id_sub_channel_inserted = $this->subChannelRepository->addSubChannel($save, $sub_channel_id);

        // Store data for only a single request and destory
        request()->session()->flash('message', 'sub Channel has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.sub_channel.index');
    }

    public function delete($id) {
        $this->subChannelRepository->deleteSubChannel($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'sub Channel has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.sub_channel.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->subChannelRepository->addSubChannel($save, $id);
        request()->session()->flash('message', 'Sub Channel has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.sub_channel.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->subChannelRepository->addSubChannel($save, $id);
        request()->session()->flash('message', 'Sub Channel has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.sub_channel.index');
    }

}
