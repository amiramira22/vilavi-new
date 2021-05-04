<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\SubCategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;

class SubCategoryController extends Controller {

    protected $categoryRepository;
    protected $subCategoryRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $subCategoryRepository) {
 parent::__construct();
        $this->categoryRepository = $categoryRepository;
        $this->subCategoryRepository = $subCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        //$search = \Request::get('search');

        $title = 'Sub Categories';
        $subTitle = 'List of Sub Categories';
//        $totalproducts = $this->productRepository->getPaginate(20);
//        $links = $totalproducts->setPath('')->render();
        //$subCategories = $this->subCategoryRepository->getSubCategories($search);
        return view('admin.sub_category.index', compact('title', 'subTitle'));
    }

    public function getSubCategories(Request $request) {

        $columns = array(
            0 => 'code',
            1 => 'name',
            2 => 'categories.name',
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

        $sub_categories = $this->subCategoryRepository->getAjaxSubCategories($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($sub_categories);
    }

    public function create() {
        $title = 'Sub Categories';
        $subTitle = 'Creat Sub Category';

        $categories = $this->categoryRepository->listCategories(['id', 'name']);
        $categories = $categories->pluck('name', 'id');
        return view('admin.sub_category.create', compact('title', 'subTitle', 'categories'));
    }

    public function edit($id) {
        $title = 'Sub Categories';
        $subTitle = 'Edit Sub Category';
        $subCategory = $this->subCategoryRepository->getSubCategoryById($id);

        $categories = $this->categoryRepository->listCategories(['id', 'name']);
        $categories = $categories->pluck('name', 'id');
        $categories->prepend($subCategory->category->name, $subCategory->category->id);
        return view('admin.sub_category.edit', compact('title', 'subTitle', 'subCategory', 'categories'));
    }

    public function postSubCategory(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        if ($request->input('id'))
            $sub_category_id = $request->input('id');
        else
            $sub_category_id = '';

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');
        $save['category_id'] = $request->input('category_id');

        $id_sub_category_inserted = $this->subCategoryRepository->addSubCategory($save, $sub_category_id);
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
        request()->session()->flash('message', 'Sub Category has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.sub_category.index');
    }

    public function delete($id) {
        $this->subCategoryRepository->deleteSubCategory($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Sub Category has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.sub_category.index');
    }

    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->subCategoryRepository->addSubCategory($save, $id);
        request()->session()->flash('message', 'Sub Category has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.sub_category.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->subCategoryRepository->addSubCategory($save, $id);
        request()->session()->flash('message', 'Sub Category has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.sub_category.index');
    }

}
