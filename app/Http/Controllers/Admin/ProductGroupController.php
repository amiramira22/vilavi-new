<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadRequest;
use App\Repositories\ProductGroupRepository;
use App\Repositories\ClusterRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class ProductGroupController extends Controller {

    protected $productGroupRepository;
    protected $clusterRepository;

    public function __construct(ProductGroupRepository $productGroupRepository, ClusterRepository $clusterRepository) {
         parent::__construct();
        $this->clusterRepository = $clusterRepository;
        $this->productGroupRepository = $productGroupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        //$search = \Request::get('search');

        $title = ' Product Groups ';
        $subTitle = 'List of product groups';
//        $totalproducts = $this->productRepository->getPaginate(20);
//        $links = $totalproducts->setPath('')->render();
        //$product_groups = $this->productGroupRepository->getProductGroups($search);
        //dd($product_groups);
        return view('admin.product_groups.index', compact('title', 'subTitle'));
    }

    // Ajax Datatable
    public function getProductGroups(Request $request) {

        $columns = array(
            0 => 'code',
            1 => 'name',
            2 => 'clusters.name',
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

        $product_groups = $this->productGroupRepository->getAjaxProductGroups($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($product_groups);
    }

    public function create() {
        $title = 'Product Groups';
        $subTitle = 'Creat Product Groups';

        $clusters = $this->clusterRepository->listClusters(['id', 'name']);
        $clusters = $clusters->pluck('name', 'id');
        return view('admin.product_groups.create', compact('title', 'subTitle', 'clusters'));
    }

    public function edit($id) {
        $title = 'Product Groups';
        $subTitle = 'Edit Product Groups';
        $product_group = $this->productGroupRepository->getProductGroupById($id);

        $clusters = $this->clusterRepository->listClusters(['id', 'name']);
        $clusters = $clusters->pluck('name', 'id');
        $clusters->prepend($product_group->cluster->name, $product_group->cluster->id);

        return view('admin.product_groups.edit', compact('title', 'subTitle', 'product_group', 'clusters'));
    }

    public function postProductGroup(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        if ($request->input('id'))
            $product_group_id = $request->input('id');
        else
            $product_group_id = '';

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['cluster_id'] = $request->input('cluster_id');

        $id_product_group_inserted = $this->productGroupRepository->addProductGroup($save, $product_group_id);
//        if (!$request->input('id')) {
//            if ($request->photos) {
//                foreach ($request->photos as $photo) {
//                    //dd($photo->store('photos'));
//                    $filename = $photo->store('photos');
//                    //dd($filename);
//                    $save_file['filename'] = $filename;
//                    $save_file['product_id'] = $id_product_inserted;
//                    $this->productPhotoRepository->addProductPhoto($save_file);
//                }
//            }
//        }
        //dd($save);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Product Group has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.product_group.index');
    }

    public function delete($id) {
        $this->productGroupRepository->deleteProductGroup($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Product Group has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.product_group.index');
    }
    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->productGroupRepository->addProductGroup($save, $id);
        request()->session()->flash('message', 'Product Group has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.product_group.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->productGroupRepository->addProductGroup($save, $id);
        request()->session()->flash('message', 'Product Group has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.product_group.index');
    }
}
