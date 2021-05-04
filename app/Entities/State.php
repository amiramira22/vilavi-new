<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class State extends Model {

    protected $table = 'states';
    protected $fillable = ['id', 'code', 'name', 'color', 'active', 'zone_id'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function zone() {
        return $this->belongsTo('App\Entities\Zone', 'zone_id', 'id');
    }

    public function outlet() {
        return $this->hasMany('App\Entities\Outlet', 'state_id', 'id');
    }

}
