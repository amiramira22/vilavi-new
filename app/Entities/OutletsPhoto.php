<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OutletsPhoto extends Model {

    protected $table = 'outlets_photos';
    protected $fillable = ['outlet_id', 'filname'];
    protected $primaryKey = 'id';
  

    public function outlet() {
        return $this->hasOne('App\Entities\Outlet', 'id', 'outlet_id');
    }

}
