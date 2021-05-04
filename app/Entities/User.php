<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'admin';
    protected $fillable = ['id', 'name', 'email', 'username', 'access', 'password', 'active', 'photos','lang'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function outlet() {
        return $this->hasMany('App\Entities\Outlet', 'admin_id', 'id');
    }

    public function visit() {
        return $this->hasMany('App\Entities\Visit', 'admin_id', 'id');
    }

}
