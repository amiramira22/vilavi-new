<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadRequest;
use App\Repositories\ClusterRepository;
use App\Repositories\SubCategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class ClusterController extends Controller {

    protected $clusterRepository;
    protected $subCategoryRepository;

    public function __construct(ClusterRepository $clusterRepository, SubCategoryRepository $subCategoryRepository) {
        parent::__construct();
        $this->clusterRepository = $clusterRepository;
        $this->subCategoryRepository = $subCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $title = 'cluster ';
        $subTitle = 'List of clusters';
//        $totalproducts = $this->productRepository->getPaginate(20);
//        $links = $totalproducts->setPath('')->render();
        //$clusters = $this->clusterRepository->getClusters($search);
//        return view('admin.clusters.index', compact('clusters', 'title', 'subTitle', 'search'));
        return view('admin.clusters.index', compact('title', 'subTitle'));
    }

    // Ajax Datatable
    public function getClusters(Request $request) {

        $columns = array(
            0 => 'code',
            1 => 'name',
            2 => 'sub_categories.name',
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

        $clusters = $this->clusterRepository->getAjaxClusters($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($clusters);
    }

    public function create() {
        $title = 'cluster';
        $subTitle = 'Creat Cluster';

        $subcategories = $this->subCategoryRepository->listSubCategories(['id', 'name']);
        $subcategories = $subcategories->pluck('name', 'id');
        return view('admin.clusters.create', compact('title', 'subTitle', 'subcategories'));
    }

    public function edit($id) {
        $title = 'cluster';
        $subTitle = 'Edit Cluster';
        $cluster = $this->clusterRepository->getClusterById($id);

        $subcategories = $this->subCategoryRepository->listSubCategories(['id', 'name']);
        $subcategories = $subcategories->pluck('name', 'id');
        $subcategories->prepend($cluster->subCategory->name, $cluster->subCategory->id);

        return view('admin.clusters.edit', compact('title', 'subTitle', 'cluster', 'subcategories'));
    }

    public function postCluster(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        if ($request->input('id'))
            $cluster_id = $request->input('id');
        else
            $cluster_id = '';

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['sub_category_id'] = $request->input('sub_category_id');

        $id_cluster_inserted = $this->clusterRepository->addCluster($save, $cluster_id);
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
        request()->session()->flash('message', 'Cluster has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.cluster.index');
    }

    public function delete($id) {
        $this->clusterRepository->deleteCluster($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Cluster has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.cluster.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->clusterRepository->addCluster($save, $id);
        request()->session()->flash('message', 'cluster has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.cluster.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->clusterRepository->addCluster($save, $id);
        request()->session()->flash('message', 'cluster has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.cluster.index');
    }

}
