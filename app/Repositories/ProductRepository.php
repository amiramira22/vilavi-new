<?php

//pharmacie

namespace App\Repositories;

use App\Entities\Product;
use DB;

class ProductRepository extends ResourceRepository
{

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function countProducts($search = '-1')
    {
        if ($search == '-1') {
            return Product::count();
        } else {
            return Product::leftjoin('product_groups', 'products.product_group_id', '=', 'product_groups.id')
                ->leftjoin('brands', 'products.brand_id', '=', 'brands.id')
                ->where('products.code', 'like', "%{$search}%")
                ->orWhere('products.name', 'like', "%{$search}%")
                ->orWhere('product_groups.name', 'like', "%{$search}%")
                ->orWhere('brands.name', 'like', "%{$search}%")
                ->count();
        }
        return Product::count();
    }

    public function getAjaxProducts($start = 0, $limit = 0, $order = 'products.id', $dir = 'DESC', $draw = 0, $search = '-1')
    {

        // get sales filtred rows
        $products = Product::select('products.*', 'product_groups.name as product_group_name', 'products.image as image', 'brands.name as brand_name')
            ->leftjoin('product_groups', 'products.product_group_id', '=', 'product_groups.id')
//                ->leftjoin('products_photos', 'products.id', '=', 'products_photos.product_id')
            ->leftjoin('brands', 'products.brand_id', '=', 'brands.id');


        if ($search != '-1') {
            $products->where('products.code', 'like', "%{$search}%");
            $products->orWhere('products.name', 'like', "%{$search}%");
            $products->orWhere('product_groups.name', 'like', "%{$search}%");
            $products->orWhere('brands.name', 'like', "%{$search}%");
        }

        $products->offset($start);
        $products->limit($limit);
        $products->orderBy($order, $dir);
        $products = $products->get();

        // Total sales rows
        $totalData = $this->countProducts($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($products) {

            foreach ($products as $c) {
                if (isset($c->image))
                    $image = $c->image;
                else
                    $image = 'introuvable.png';
                //$nestedData['image'] = '<img src="../public/products_photo/$c->filename" alt="" class="responsive-img left" height="50" width="50" alt="current">';
                $nestedData['image'] = "<img src='https://hcm.capesolution.tn/uploads/product/" . $image . "'  class='responsive-img left' height='50' width='50' alt='current'>";


                $nestedData['code'] = $c->code;
                $nestedData['product'] = $c->name;
                $nestedData['product_group'] = $c->product_group_name;
                $nestedData['brand'] = $c->brand_name;


                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="product/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="product/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this product ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="product/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="product/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="product/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this product ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="product/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
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

    public function getProducts($search = '')
    {

        $products = Product::select('products.*')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('code')
            ->paginate(20);
        //set the value of the search
        $products->appends(['search' => $search]);
        //  dd($products);
        return $products;
    }

    public function addProduct($save, $id = '')
    {

        if ($id == '') {
            $id = DB::table('products')->insertGetId(
                $save
            );
        } else {
            DB::table('products')
                ->where('products.id', $id)
                ->update($save);
        }
        return $id;
    }

    public function deleteProduct($id)
    {

        DB::table('products')->where('products.id', $id)->delete();
    }

    public function getProductById($id)
    {

        $product = Product::select('products.*')
            ->where('products.id', $id)
            ->first();
        //dd($product);
        return $product;
    }

    public function getProductByBrand($brand_id)
    {

        $query = Product::select('products.id as product_id'
            , 'products.name as product_name'
            , 'product_groups.id as product_group_id'
            , 'product_groups.name as product_group_name'
            , 'clusters.name as cluster_name'
            , 'clusters.id as cluster_id'
            , 'sub_categories.name as sub_category_name'
            , 'sub_categories.id as sub_category_id'
            , 'categories.id as category_id'
            , 'categories.name as category_name')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('brands.id', '=', $brand_id)
            ->get();
        return $query;
    }

    public function get_active_products()
    {

        $query = Product::select('products.id as id'
            , 'products.code as product_code'
            , 'products.name as product_name'
            , 'product_groups.id as product_group_id'
            , 'product_groups.name as product_group_name'
            , 'clusters.name as cluster_name'
            , 'clusters.id as cluster_id'
            , 'sub_categories.name as sub_category_name'
            , 'sub_categories.id as sub_category_id'
            , 'categories.id as category_id'
            , 'categories.name as category_name'
            , 'brands.name as brand_name')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('products.active', '=', 1)
            ->get();
        return $query;
    }

    function get_ha_products($outlet_id = false)
    {
        $query = Product::select('products.id as product_id')
            ->leftjoin('ha', 'products.id', '=', 'ha.product_id')
            ->leftjoin('outlets', 'ha.outlet_id', '=', 'outlets.id')
            ->where('outlets.id', '=', $outlet_id)
            ->get();

        $data = array();
        foreach ($query as $row) {
            $data[] = $row->product_id;
        }
        return $data;
    }

    function delete_ha_product($product_id, $outlet_id)
    {

        DB::table('ha')->where('product_id', '=', $product_id)
            ->where('outlet_id', '=', $outlet_id)
            ->delete();
    }

    function add_ha_product($product)
    {
        return DB::table('ha')->insertGetId($product);
    }

    public function get_data_for_dn_maps_report($data, $type)
    {

        $query = Product::select('products.id as product_id'
            , 'products.name as product_name'
            , 'product_groups.id as product_group_id'
            , 'product_groups.name as product_group_name'
            , 'clusters.name as cluster_name'
            , 'clusters.id as cluster_id'
            , 'sub_categories.name as sub_category_name'
            , 'sub_categories.id as sub_category_id'
            , 'categories.id as category_id'
            , 'categories.name as category_name')
            ->join('product_groups', 'products.product_group_id', '=', 'product_groups.id')
            ->join('clusters', 'product_groups.cluster_id', '=', 'clusters.id')
            ->join('sub_categories', 'clusters.sub_category_id', '=', 'sub_categories.id')
            ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->where('brands.id', 1);

        if ($type === 'specific_category' && $data != 0) {
            //echo 'specific_category';
            $query->where('categories.id', $data);
            //->where('categories.active', 1);
        }
        if ($type == 'specific_sub_category' && $data != 0) {
            $query->where('sub_categories.id', $data);
            //->where('sub_categories.active', 1);
        }
        /*  if ($type == 'specific_cluster' && $data != 0) {
              $query->where('clusters.id', $data)
                  ->where('clusters.active', 1);
          }*/
        if ($type == 'specific_product_group' && $data != 0) {
            $query->where('product_groups.id', $data);
            //->where('product_groups.active', 1);
        }
        if ($type == 'specific_product' && $data != 0) {
            $query->where('products.id', $data);
            //->where('products.active', 1);
        }

        return $query->get();
    }


}
