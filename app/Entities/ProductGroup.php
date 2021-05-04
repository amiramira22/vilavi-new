<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model {

    protected $table = 'product_groups';
    protected $fillable = ['id', 'code', 'name', 'brand_id', 'active', 'other', 'cluster_id'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function cluster() {
        return $this->belongsTo('App\Entities\Cluster');
    }

    public function product() {
        return $this->hasMany('App\Entities\Product');
    }

    public function brand() {
        return $this->belongsTo('App\Entities\Brand');
    }

}
