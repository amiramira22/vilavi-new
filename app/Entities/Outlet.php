<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model {

    protected $table = 'outlets';
    protected $fillable = ['id', 'code', 'name', 'admin_id', 'channel_id', 'channel', 'zone_id', 'zone', 'state', 'state_id', 'sub_channel_id', 'sub_channel', 'adress', 'photos','visit_day'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function outletZone() {
        return $this->belongsTo('App\Entities\Zone', 'zone_id', 'id');
    }

    public function outletUser() {
        return $this->belongsTo('App\Entities\User', 'admin_id', 'id');
    }

    public function outletState() {
        return $this->belongsTo('App\Entities\State', 'state_id', 'id');
    }

    public function outletChannel() {
        return $this->belongsTo('App\Entities\Channel', 'channel_id', 'id');
    }

    public function outletSubChannel() {
        return $this->belongsTo('App\Entities\SubChannel', 'sub_channel_id', 'id');
    }

    public function photo() {
        return $this->hasMany('App\Entities\OutletsPhoto', 'outlet_id', 'id');
    }

    public function visit() {
        return $this->hasMany('App\Entities\Visit', 'outlet_id', 'id');
    }

}
