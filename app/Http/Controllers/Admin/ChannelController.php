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
use App\Repositories\ChannelRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class ChannelController extends Controller {

    protected $channelRepository;

    public function __construct(ChannelRepository $channelRepository) {
 parent::__construct();
        $this->channelRepository = $channelRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = 'channel';
        $subTitle = 'List of Channels';
        return view('admin.channels.index', compact('title', 'subTitle'));
    }

    public function getChannels(Request $request) {
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
        $channels = $this->channelRepository->getAjaxChannels($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($channels);
    }

    public function create() {
        $title = 'channel';
        $subTitle = 'Creat Channel';
        return view('admin.channels.create', compact('title', 'subTitle'));
    }

    public function edit($id) {
        $title = 'channel';
        $subTitle = 'Edit Channel';
        $channel = $this->channelRepository->getChannelById($id);
        return view('admin.channels.edit', compact('title', 'subTitle', 'channel'));
    }

    public function postChannel(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'color' => 'required',
            'code' => 'required|numeric',
        ]);

        if ($request->input('id'))
            $channel_id = $request->input('id');
        else {
            $this->validate($request, [
                'name' => '|unique:channels,name',
                'color' => 'unique:channels,color',
                'code' => 'unique:channels,code',
            ]);
            $channel_id = '';
        }

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['color'] = $request->input('color');


        $id_channel_inserted = $this->channelRepository->addChannel($save, $channel_id);

        // Store data for only a single request and destory
        request()->session()->flash('message', 'Channel has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.channel.index');
    }

    public function delete($id) {
        $this->channelRepository->deleteChannel($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Channel has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.channel.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->channelRepository->addCategory($save, $id);
        request()->session()->flash('message', 'channel has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.channel.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->channelRepository->addCategory($save, $id);
        request()->session()->flash('message', 'channel has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.channel.index');
    }

}
