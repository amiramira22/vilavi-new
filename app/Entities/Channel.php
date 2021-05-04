<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model {

    protected $table = 'channels';
    protected $fillable = [
        'id', 'code', 'name', 'color', 'active'
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function sub_channel() {
        return $this->hasMany('App\Entities\SubChannel', 'channel_id', 'id');
    }

    public function outlet() {
        return $this->hasMany('App\Entities\Outlet', 'channel_id', 'id');
    }

}
