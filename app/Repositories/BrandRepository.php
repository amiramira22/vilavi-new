<?php

namespace App\Repositories;

use App\Entities\Brand;
use DB;

class BrandRepository extends ResourceRepository {

    public function __construct(Brand $brand) {
        $this->model = $brand;
    }

    public function countBrands($search = '-1') {
        if ($search == '-1') {
            return Brand::count();
        } else {
            return Brand::where('brands.code', 'like', "%{$search}%")
                            ->orWhere('brands.name', 'like', "%{$search}%")
                            ->count();
        }
        return Brand::count();
    }

    public function listBrands() {

        $brands = Brand::orderBy('code')
                ->get();
        return $brands;
    }

    public function getAjaxBrands($start = 0, $limit = 0, $order = 'brands.id', $dir = '', $draw = 0, $search = '-1') {

        // get sales filtred rows
        $brands = Brand::select('brands.*');



        if ($search != '-1') {
            $brands->where('brands.code', 'like', "%{$search}%");
            $brands->orWhere('brands.name', 'like', "%{$search}%");
        }

        $brands->offset($start);
        $brands->limit($limit);
        $brands->orderBy($order, $dir);
        $brands = $brands->get();

        // Total sales rows
        $totalData = $this->countBrands($search);
        $totalFiltered = $totalData;


        $data = array();
        if ($brands) {

            foreach ($brands as $c) {

                $nestedData['code'] = $c->code;
                $nestedData['brand'] = $c->name;

                $nestedData['color'] = '<style>
                .m-badge.m-badge--color' . $c->id . ' {
                background-color:' . $c->color . ' !important;
                color: #fff;
                }
                </style > <span class="m-badge m-badge--color' . $c->id . '"></span>';

                if ($c->active == 1) {
                    $nestedData['status'] = '<span class="m-badge  m-badge--info m-badge--wide">Enabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="brand/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="brand/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this brand ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="brand/desactivate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="desactivate">	
                                <i class="fa fa-thumbs-down"></i>				
                            </a>
                        </span>';
                } else if ($c->active == 0) {
                    $nestedData['status'] = '<span class = "m-badge  m-badge--danger m-badge--wide">Desabled</span>';
                    $nestedData['action'] = '<span style="overflow: visible; position: relative; width: 110px;">						
                            <a href="brand/edit/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">	
                                <i class="fas fa-edit"></i>				
                            </a>						
                            <a href="brand/delete/' . $c->id . '" onclick="return confirm(\'Are you sure you want to delete this brand ?\')" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">	
                                <i class="fas fa-trash"></i>				
                            </a>
                            <a href="brand/activate/' . $c->id . '"  class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="activate">	
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

    public function getBrands($search = '') {

        $brands = Brand::select('brands.*')
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('code')
                ->paginate(20);
        //set the value of the search
        $brands->appends(['search' => $search]);
        //  dd($brands);
        return $brands;
    }

    public function addBrand($save, $id = '') {

        if ($id == '') {
            $id = DB::table('brands')->insertGetId(
                    $save
            );
        } else {
            DB::table('brands')
                    ->where('brands.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteBrand($id) {

        DB::table('brands')->where('brands.id', $id)->delete();
    }

    public function getBrandById($id) {

        $brand = Brand::select('brands.*')
                ->where('brands.id', $id)
                ->first();
        //dd($brand);
        return $brand;
    }

}
