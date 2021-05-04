<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model {

    protected $table = 'brands';
    protected $fillable = [
        'code', 'name', 'color', 'active', 'selected'
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function myModel() {
        return $this->hasMany('App\Entities\MyModel', 'brand_id', 'id');
    }

    public function product() {
        return $this->hasMany('App\Entities\Product', 'product_id', 'id');
    }

}
