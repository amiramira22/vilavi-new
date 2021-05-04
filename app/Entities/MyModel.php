<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MyModel extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'models';
    protected $fillable = ['id', 'visit_id', 'visit_uniqueId', 'product_id', 'brand_id', 'product_group_id', 'av', 'av_sku', 'nb_sku', 'sku_display',
        'shelf', 'promo_price', 'price'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function visit() {
        return $this->belongsTo('App\Entities\Visit', 'visit_id', 'id');
    }

    public function product() {
        return $this->belongsTo('App\Entities\Product', 'product_id', 'id');
    }

    public function brand() {
        return $this->belongsTo('App\Entities\Brand', 'brand_id', 'id');
    }

}
