<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model {

    protected $table = 'sub_categories';
    protected $fillable = ['id', 'code', 'name', 'category_id', 'active'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function category() {
        return $this->belongsTo('App\Entities\Category');
    }

    public function cluster() {
        return $this->hasMany('App\Entities\Cluster');
    }

}
