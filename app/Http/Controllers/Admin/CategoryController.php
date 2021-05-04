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

class CategoryController extends Controller {

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
 parent::__construct();
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

//        $search = \Request::get('search');

        $title = 'category';
        $subTitle = 'List of Categories';
//        $totalproducts = $this->productRepository->getPaginate(20);
//        $links = $totalproducts->setPath('')->render();
//        $categories = $this->categoryRepository->getCategories($search);
        return view('admin.categories.index', compact('title', 'subTitle'));
    }

    public function getCategories(Request $request) {

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

        $categories = $this->categoryRepository->getAjaxCategories($start, $limit, $order, $dir, $draw, $search);
        echo json_encode($categories);
    }

    public function create() {
        $title = 'category';
        $subTitle = 'Creat Category';
        return view('admin.categories.create', compact('title', 'subTitle'));
    }

    public function edit($id) {
        $title = 'category';
        $subTitle = 'Edit Category';
        $category = $this->categoryRepository->getCategoryById($id);
        return view('admin.categories.edit', compact('title', 'subTitle', 'category'));
    }

    public function postCategory(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        if ($request->input('id'))
            $category_id = $request->input('id');
        else
            $category_id = '';

        $save['name'] = $request->input('name');
        $save['code'] = $request->input('code');

        $id_category_inserted = $this->categoryRepository->addCategory($save, $category_id);
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
        request()->session()->flash('message', 'Category has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.category.index');
    }

    public function delete($id) {
        $this->categoryRepository->deleteCategory($id);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Category has been deleted.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.category.index');
    }
    
    
    public function activate($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->categoryRepository->addCategory($save, $id);
        request()->session()->flash('message', 'Category has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.category.index');
    }

    public function desactivate($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->categoryRepository->addCategory($save, $id);
        request()->session()->flash('message', 'Category has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.category.index');
    }

}
