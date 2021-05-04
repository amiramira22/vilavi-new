<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Entities\Outlet;
use App\Http\Requests\UploadRequest;
use App\Repositories\ProductRepository;
use App\Repositories\ProductPhotoRepository;
use App\Repositories\ProductGroupRepository;
use App\Repositories\BrandRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class ProductController extends Controller {

    protected $productRepository;
    protected $productPhotoRepository;
    protected $productGroupRepository;
    protected $brandRepository;

    public function __construct(ProductRepository $productRepository, ProductPhotoRepository $productPhotoRepository, ProductGroupRepository $productGroupRepository, BrandRepository $brandRepository) {
         parent::__construct();
        $this->productRepository = $productRepository;
        $this->productPhotoRepository = $productPhotoRepository;
        $this->productGroupRepository = $productGroupRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


        //$search = \Request::get('search');

        $title = 'product';
        $subTitle = 'List of products';
//        $totalproducts = $this->productRepository->getPaginate(20);
//        $links = $totalproducts->setPath('')->render();
        //$products = $this->productRepository->getProducts($search);
        return view('admin.products.index', compact('title', 'subTitle'));
    }

    public function ha_products($outlet_id) {
        $data['title'] = 'Products';
        $data['subTitle'] = 'HA Products | ' . Outlet::find($outlet_id)->name;
        $data['products'] = $this->productRepository->get_active_products();
        $data['ha_product_ids'] = $this->productRepository->get_ha_products($outlet_id);
        $data['outlet_id'] = $outlet_id;

        return view('admin.products.ha_products', $data);
    }

    // Action ha product
    function disable(Request $request) {
        $product_id = $request->input("product_id");
        $outlet_id = $request->input("outlet_id");

        $this->productRepository->delete_ha_product($product_id, $outlet_id);
        echo '<a onclick=" enable(' . $product_id . ',' . $outlet_id . ')" class="btn btn-circle red btn-outline"  data-toggle="tooltip" data-placement="top" title="Disable"><i class="fa fa-thumbs-down"></i></a>';
    }

    function enable(Request $request) {

        $product_id = $request->input("product_id");
        $outlet_id = $request->input("outlet_id");
        //$ha['id'] = false;
        $ha['product_id'] = $product_id;
        $ha['outlet_id'] = $outlet_id;
        $this->productRepository->add_ha_product($ha);
        echo '<a  onclick="disable(' . $product_id . ',' . $outlet_id . ')" class="btn btn-circle green btn-outline" data-toggle="tooltip" data-placement="top" title="Enable"><i class="fa fa-thumbs-up"></i> </a>';
    }

    // Ajax Datatable
    public function getProducts(Request $request) {

        $columns = array(
            0 => 'products.id',
            1 => 'code',
            2 => 'name',
            3 => 'product_groups.name',
            4 => 'product_groups.name',
            5 => 'active'
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

        $products = $this->productRepository->getAjaxProducts($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($products);
    }

    public function create() {
        $title = 'product';
        $subTitle = 'Creat Product';

        $productgroups = $this->productGroupRepository->listProductGroups(['id', 'name']);
        $productgroups = $productgroups->pluck('name', 'id');


        $brands = $this->brandRepository->listBrands(['id', 'name']);
        $brands = $brands->pluck('name', 'id');


        return view('admin.products.create', compact('title', 'subTitle', 'productgroups', 'brands'));
    }

    public function edit($id) {
        $title = 'product';
        $subTitle = 'Edit Product';
        $product = $this->productRepository->getProductById($id);

        $productgroups = $this->productGroupRepository->listProductGroups(['id', 'name']);
        $productgroups = $productgroups->pluck('name', 'id');
        $productgroups->prepend($product->productGroup->name, $product->productGroup->id);


        $brands = $this->brandRepository->listBrands(['id', 'name']);
        $brands = $brands->pluck('name', 'id');
        $brands->prepend($product->brand->name, $product->brand->id);




        return view('admin.products.edit', compact('title', 'subTitle', 'product', 'productgroups', 'brands'));
    }

    public function postProduct(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        if ($request->input('id'))
            $product_id = $request->input('id');
        else
            $product_id = '';

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['product_group_id'] = $request->input('product_group_id');
        $save['brand_id'] = $request->input('brand_id');


        $id_product_inserted = $this->productRepository->addProduct($save, $product_id);

        if ($request->photo) {
//                foreach ($request->photos as $photo) {
//                    //dd($photo->store('photos'));
//                    //$filename = $photo->store('photos');
//                    $filename = $photo->getClientOriginalName();
//                    $photo->move(public_path('products_photo'), $filename);
//                    //dd($filename);
//                    $save_file['filename'] = $filename;
//                    $save_file['product_id'] = $id_product_inserted;
//                    $this->productPhotoRepository->addProductPhoto($save_file);
//                }
            $photo = $request->photo;
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path('products_photo'), $filename);
            //dd($filename);
            $save_file['filename'] = $filename;
            $save_file['product_id'] = $id_product_inserted;
            $this->productPhotoRepository->addProductPhoto($save_file, $product_id);
        }

        //dd($save);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Product has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.product.index');
    }

    public function delete($id) {
        $this->productRepository->deleteProduct($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Product has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.product.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->productRepository->addProduct($save, $id);
        request()->session()->flash('message', 'product has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.product.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->productRepository->addProduct($save, $id);
        request()->session()->flash('message', 'product has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.product.index');
    }

}
