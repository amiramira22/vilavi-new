<?php

//pharmacie

namespace App\Repositories;

use App\Entities\SubCategory;
use DB;

class SubCategoryRepository extends ResourceRepository {

    public function __construct(SubCategory $subCategory) {
        $this->model = $subCategory;
    }

    public function countSubCategories($search = '-1') {
        if ($search == '-1') {
            return SubCategory::count();
        } else {
            return SubCategory::leftjoin('categories', 'sub_categories.category_id', '=', 'categories.id')
                            ->where('sub_categories.code', 'like', "%{$search}%")
                            ->orWhere('sub_categories.name', 'like', "%{$search}%")
                            ->orWhere('categories.name', 'like', "%{$search}%")
                            ->count();
        }
        return SubCategory::count();
    }

    public function getAjaxSubCategories($start = 0, $limit = 0, $order = 'sub_categories.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $sub_categories = SubCategory::select('sub_categories.*', 'categories.name as category_name')
                ->leftjoin('categories', 'sub_categories.category_id', '=', 'categories.id');

        if ($search != '-1') {
            $sub_categories->where('sub_categories.code', 'like', "%{$search}%");
            $sub_categories->orWhere('sub_categories.name', 'like', "%{$search}%");
            $sub_categories->orWhere('categories.name', 'like', "%{$search}%");
        }

        $sub_categories->offset($start);
        $sub_categories->limit($limit);
        $sub_categories->orderBy($order, $dir);
        $sub_categories = $sub_categories->get();

        // Total sales rows
        $totalData = $this->countSubCategories($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($sub_categories) {
            foreach ($sub_categories as $c) {
                $nestedData['code'] = $c->code;
                $nestedData['sub_category'] = $c->name;
                $nestedData['category'] = $c->category_name;
                $nestedData['status'] = $c->active;

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="sub_category/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="sub_category/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this sub category ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="sub_category/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="sub_category/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="sub_category/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this sub category ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="sub_category/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
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

    public function listSubCategories() {

        $subCategories = SubCategory::select('sub_categories.*')
                ->orderBy('code')
                ->get();
        return $subCategories;
    }

    public function getSubCategories($search) {

        $subCategories = SubCategory::select('sub_categories.*')
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('code')
                ->paginate(20);
        //set the value of the search
        $subCategories->appends(['search' => $search]);
        //  dd($products);
        return $subCategories;
    }

    public function addSubCategory($save, $id = '') {

        if ($id == '') {
            $id = DB::table('sub_categories')->insertGetId(
                    $save
            );
        } else {
            DB::table('sub_categories')
                    ->where('sub_categories.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteSubCategory($id) {

        DB::table('sub_categories')->where('sub_categories.id', $id)->delete();
    }

    public function getSubCategoryById($id) {

        $subCategory = SubCategory::select('sub_categories.*')
                ->where('sub_categories.id', $id)
                ->first();
        //dd($subCategory);
        return $subCategory;
    }

}
