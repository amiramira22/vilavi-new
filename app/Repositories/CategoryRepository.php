<?php

//pharmacie

namespace App\Repositories;

use App\Entities\Category;
use DB;

class CategoryRepository extends ResourceRepository {

    public function __construct(Category $category) {
        $this->model = $category;
    }

    public function getAjaxCategories($start = 0, $limit = 0, $order = 'categories.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $categories = Category::select('categories.*');


        if ($search != '-1') {
            $categories->where('categories.code', 'like', "%{$search}%");
            $categories->orWhere('categories.name', 'like', "%{$search}%");
        }

        $categories->offset($start);
        $categories->limit($limit);
        $categories->orderBy($order, $dir);
        $categories = $categories->get();

        // Total sales rows
        $totalData = $this->countCategories($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($categories) {
            foreach ($categories as $c) {
                $nestedData['code'] = $c->code;
                $nestedData['category'] = $c->name;
                $nestedData['status'] = $c->active;

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="category/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="category/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this category ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="category/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="category/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="category/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this category ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="category/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
                                <i class="fa fa-thumbs-up"></i>				
                            </a>
                          
                        </span>';
                }
                $data[] = $nestedData;
            }
        }

        return array(
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
    }

    public function listCategories() {

        $categories = Category::select('categories.*')
                ->orderBy('code')
                ->get();
        return $categories;
    }

    public function getCategories($search = '') {

        $categories = Category::select('categories.*')
                ->orderBy('id', 'asc')
                ->paginate(20);
        //set the value of the search
        if ($search != '')
            $categories->where('name', 'like', '%' . $search);
        $categories->appends(['search' => $search]);
        //  dd($products);
        return $categories;
    }

    public function getLimitCategories($limit = -1, $offset = -1) {

        $categories = Category::select('categories.*')
                ->orderBy('id', 'asc');

        if ($limit != -1 && $offset != -1) {
            $categories->limit($limit)
                    ->offset($offset);
        }
        return $categories->get();

//        dd($categories->toSql());
    }

    public function countCategories($search = '-1') {
        if ($search == '-1') {
            return Category::count();
        } else {
            return Category::where('categories.code', 'like', "%{$search}%")
                            ->orWhere('categories.name', 'like', "%{$search}%")
                            ->count();
        }
        return Category::count();
    }

    public function addCategory($save, $id = '') {

        if ($id == '') {
            $id = DB::table('categories')->insertGetId(
                    $save
            );
        } else {
            DB::table('categories')
                    ->where('categories.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteCategory($id) {

        DB::table('categories')->where('categories.id', $id)->delete();
    }

    public function getCategoryById($id) {

        $category = Category::select('categories.*')
                ->where('categories.id', $id)
                ->first();
        //dd($category);
        return $category;
    }

}
