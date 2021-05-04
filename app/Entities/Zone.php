<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model {

    protected $table = 'zones';
    protected $fillable = [
        'id', 'code', 'name', 'active', 'color',
    ];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function state() {
        return $this->hasMany('App\Entities\State', 'zone_id', 'id');
    }

    public function outlet() {
        return $this->hasMany('App\Entities\Outlet', 'zone_id', 'id');
    }

}
