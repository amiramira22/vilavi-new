<?php

//pharmacie

namespace App\Repositories;

use App\Entities\ProductsPhoto;
use DB;

class ProductPhotoRepository extends ResourceRepository {

    public function __construct(ProductsPhoto $productPhoto) {
        $this->model = $productPhoto;
    }

    public function getProductPhotos() {

        $products_photos = ProductPhoto::select('products_photos.*')
                ->leftjoin('products', 'products.id', '=', 'products_photos.product_id')
                ->orderBy('name')
                ->get();
        //  dd($products);
        return $products_photos;
    }

    public function addProductPhoto($save, $product_id) {
        if ($product_id == '') {
            DB::table('products_photos')->insert(
                    $save
            );
        } else {
            DB::table('products_photos')
                    ->where('products_photos.product_id', $product_id)
                    ->update($save);
        }
 
    }

    public function deleteProductPhoto($id) {

        DB::table('products_photos')->where('products_photos.id', $id)->delete();
    }

}
