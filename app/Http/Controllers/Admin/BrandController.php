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
use App\Repositories\BrandRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class BrandController extends Controller {

    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository) {
        parent::__construct();
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = 'brand';
        $subTitle = 'List of Brands';
        return view('admin.brands.index', compact('title', 'subTitle'));
    }

    public function getBrands(Request $request) {
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
        $brands = $this->brandRepository->getAjaxBrands($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($brands);
    }

    public function create() {
        $title = 'brand';
        $subTitle = 'Creat Brand';
        return view('admin.brands.create', compact('title', 'subTitle'));
    }

    public function edit($id) {
        $title = 'brand';
        $subTitle = 'Edit Brand';
        $brand = $this->brandRepository->getBrandById($id);
        return view('admin.brands.edit', compact('title', 'subTitle', 'brand'));
    }

    public function postBrand(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'color' => 'required',
            'code' => 'required',
        ]);

        if ($request->input('id'))
            $brand_id = $request->input('id');
        else {
            $this->validate($request, [
                'name' => '|unique:brands,name',
                'color' => 'unique:brands,color',
                'code' => 'unique:brands,code',
            ]);
            $brand_id = '';
        }

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['color'] = $request->input('color');


        $id_brand_inserted = $this->brandRepository->addBrand($save, $brand_id);

        // Store data for only a single request and destory
        request()->session()->flash('message', 'Brand has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.brand.index');
    }

    public function delete($id) {
        $this->brandRepository->deleteBrand($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Brand has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.brand.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->brandRepository->addBrand($save, $id);
        request()->session()->flash('message', 'Brand has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.brand.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->brandRepository->addBrand($save, $id);
        request()->session()->flash('message', 'Brand has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.brand.index');
    }

}
