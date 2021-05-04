<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';
    protected $fillable = ['id', 'code', 'name', 'abrev_name', 'active', 'color'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function subCategory() {
        return $this->hasMany('App\Entities\SubCategory');
    }

}
