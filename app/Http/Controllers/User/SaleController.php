<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use App\Repositories\SaleRepository;
use App\Repositories\ModelRepository;
use App\Repositories\OutletRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller {

    protected $saleRepository;
    protected $outletRepository;
    protected $modelRepository;
    protected $categoryRepository;

    public function __construct(SaleRepository $saleRepository, OutletRepository $outletRepository, ModelRepository $modelRepository, CategoryRepository $categoryRepository) {
        $this->saleRepository = $saleRepository;
        $this->outletRepository = $outletRepository;
        $this->modelRepository = $modelRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index() {
        $title = 'Sales';
        $subTitle = 'List of sales';
        return view('promoter.sales.index', compact('title', 'subTitle'));
    }

    // Ajax Datatable - Journal Sales
    public function getSales(Request $request) {

        $columns = array(
            0 => 'id',
            1 => 'promoter',
            2 => 'outlet',
            3 => 'date',
            4 => 'category',
            5 => 'model',
            6 => 'qty',
            7 => 'price',
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
        
        $user_id=Auth::user()->id;

        $sales = $this->saleRepository->getAjaxSales($start, $limit, $order, $dir, $draw, $search,$user_id);
        echo json_encode($sales);
    }

    // Load add sale view by category
    public function create($category_id = 1) {
        $categories = array();
        switch ($category_id) {
            case 1:
                $title = 'Sales TV';
                $subTitle = 'Add new TV sale';
                break;
            case 2:
                $title = 'Sales REF';
                $subTitle = 'Add new REF sale';
                break;
            case 3:
                $title = 'Sales WM';
                $subTitle = 'Add new WM sale ';
                break;
            case 11:
                $title = 'Sales AC';
                $subTitle = 'Add new AC sale';
                break;
            default:
                $title = 'Other Sales';
                $subTitle = 'Add new other sale';
                $categories = $this->categoryRepository->getOtherCategories();
                $categories = $categories->pluck('name', 'id');
        }
        $outlets = $this->outletRepository->getPromoterOutlets();
        $outlets = $outlets->pluck('name', 'id');

        $models = $this->modelRepository->getModelsByCategory($category_id);
        $models = $models->pluck('name', 'id');

        return view('promoter.sales.create', compact('categories', 'models', 'outlets', 'category_id', 'title', 'subTitle'));
    }

    // Insert sale
    public function store(Request $request) {
        $this->validate($request, [
            'model_id' => 'required',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required',
                //  'remark' => 'required|string|min:6',
        ]);


        $save['admin_id'] = Auth::user()->id;
        $save['type'] = 'Sales';
        $save['model_id'] = $request->model_id;
        $save['outlet_id'] = Auth::user()->outlet_id;
        $save['date'] = date("Y-m-d H:i:s");
        $save['count'] = $request->quantity;
        $save['modified'] = date("Y-m-d H:i:s");
        $save['remark'] = $request->remark;
        $save['active'] = 1;
        $save['price'] = $request->price;
        $save['w_date'] = firstDayOf('week', $save['date']);

        $this->saleRepository->store($save);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Sale has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('promoter.sale.index');
    }

    // Ajax request get Models by selected category
    public function getModelsByCategory(Request $request) {
        $category_id = $request->category_id;
        $category_id = (int) $category_id;
        $models = $this->modelRepository->getModelsByCategory($category_id);
        $models = $models->pluck('name', 'id');
        return $models;
    }

    /**
     * Show the application selectAjax.
     *
     * @return \Illuminate\Http\Response
     */
}
