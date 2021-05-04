<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SubChannel extends Model {

    protected $table = 'sub_channels';
    protected $fillable = ['id', 'code', 'name', 'channel_id', 'active'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function channel() {
        return $this->belongsTo('App\Entities\Channel');
    }

    public function outlet() {
        return $this->hasMany('App\Entities\Outlet', 'sub_channel_id', 'id');
    }

}
