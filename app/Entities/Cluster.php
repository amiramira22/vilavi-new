<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model {

    protected $table = 'clusters';
    protected $fillable = ['id', 'code', 'name', 'sub_category_id', 'active', 'other'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function subCategory() {
        return $this->belongsTo('App\Entities\SubCategory');
    }

    public function productGroup() {
        return $this->hasMany('App\Entities\ProductGroup');
    }

}
