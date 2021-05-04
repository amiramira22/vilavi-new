<?php

//pharmacie

namespace App\Repositories;

use App\Entities\ProductGroup;
use DB;

class ProductGroupRepository extends ResourceRepository {

    public function __construct(ProductGroup $productGroup) {
        $this->model = $productGroup;
    }

    public function countProductGroups($search = '-1') {
        if ($search == '-1') {
            return ProductGroup::count();
        } else {
            return ProductGroup::leftjoin('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
                            ->where('product_groups.code', 'like', "%{$search}%")
                            ->orWhere('product_groups.name', 'like', "%{$search}%")
                            ->orWhere('clusters.name', 'like', "%{$search}%")
                            ->count();
        }
        return ProductGroup::count();
    }

    public function getAjaxProductGroups($start = 0, $limit = 0, $order = 'product_groups.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $product_groups = ProductGroup::select('product_groups.*', 'clusters.name as cluster_name')
                ->leftjoin('clusters', 'product_groups.cluster_id', '=', 'clusters.id');

        if ($search != '-1') {
            $product_groups->where('product_groups.code', 'like', "%{$search}%");
            $product_groups->orWhere('product_groups.name', 'like', "%{$search}%");
            $product_groups->orWhere('clusters.name', 'like', "%{$search}%");
        }

        $product_groups->offset($start);
        $product_groups->limit($limit);
        $product_groups->orderBy($order, $dir);
        $product_groups = $product_groups->get();

        // Total sales rows
        $totalData = $this->countProductGroups($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($product_groups) {
            foreach ($product_groups as $c) {
                $nestedData['code'] = $c->code;
                $nestedData['product_group'] = $c->name;
                $nestedData['cluster'] = $c->cluster_name;
                $nestedData['status'] = $c->active;

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="product_group/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="product_group/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this product group ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="product_group/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="product_group/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="product_group/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this product group ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="product_group/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
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

    public function listProductGroups() {

        $productGroups = ProductGroup::select('product_groups.*')
                ->orderBy('code')
                ->get();
        return $productGroups;
    }

    public function getProductGroups($search) {

        $productGroups = ProductGroup::select('product_groups.*')
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('code')
                ->paginate(20);
        //set the value of the search
        $productGroups->appends(['search' => $search]);
        //  dd($products);
        return $productGroups;
    }

    public function addProductGroup($save, $id = '') {

        if ($id == '') {
            $id = DB::table('product_groups')->insertGetId(
                    $save
            );
        } else {
            DB::table('product_groups')
                    ->where('product_groups.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteProductGroup($id) {

        DB::table('product_groups')->where('product_groups.id', $id)->delete();
    }

    public function getProductGroupById($id) {

        $productGroup = ProductGroup::select('product_groups.*')
                ->where('product_groups.id', $id)
                ->first();
        //dd($productGroup);
        return $productGroup;
    }
    
       public function get_data_for_shelf_maps_report($data, $type) {

        $query = ProductGroup::select(
                        'product_groups.id as product_group_id'
                        , 'product_groups.name as product_group_name'
                        , 'clusters.name as cluster_name'
                        , 'clusters.id as cluster_id'
                        , 'sub_categories.name as sub_category_name'
                        , 'sub_categories.id as sub_category_id'
                        , 'categories.id as category_id'
                        , 'categories.name as category_name')
                ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
                ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
                ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
                ->join('brands', 'product_groups.brand_id', '=', 'brands.id')
                ->where('brands.id', env('brand_id'));

        if ($type === 'specific_category' && $data != 0) {
            $query->where('categories.id', $data)
                    ->where('categories.active', 0);
        }
        if ($type == 'specific_sub_category' && $data != 0) {
            $query->where('sub_categories.id', $data)
                    ->where('sub_categories.active', 1);
        }
        if ($type == 'specific_cluster' && $data != 0) {
            $query->where('clusters.id', $data)
                    ->where('clusters.active', 1);
        }
        if ($type == 'specific_product_group' && $data != 0) {
            $query->where('product_groups.id', $data)
                    ->where('product_groups.active', 1);
        }


        return $query->get();
    }
    

}
