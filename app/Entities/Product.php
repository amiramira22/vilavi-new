<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';
    protected $fillable = ['code', 'name', 'product_group_id', 'brand_id', 'nb_sku', 'image', 'active'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function photo() {
        return $this->hasOne('App\Entities\ProductsPhoto', 'product_id', 'id');
    }

    public function productGroup() {
        return $this->belongsTo('App\Entities\ProductGroup');
    }

    public function myModel() {
        return $this->hasMany('App\Entities\MyModel', 'product_id', 'id');
    }

    public function brand() {
        return $this->belongsTo('App\Entities\Brand');
    }

}
