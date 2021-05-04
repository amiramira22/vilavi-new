<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model {

    protected $table = 'visits';
    protected $fillable = [
        'id', 'admin_id', 'outlet_id', 'date', 'w_date', 'm_date', 'q_date', 'entry_time', 'exit_time', 'worked_time', 'last_time', 'modified',
        'remark', 'oos_perc', 'av_perc', 'shelf_perc', 'photos', 'longitude', 'latitude', 'active', 'uniqueId', 'monthly_visit', 'was_there', 'branding_pictures', 'one_pictures', 'updated',
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function outlet() {
        return $this->belongsTo('App\Entities\Outlet', 'outlet_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\Entities\User', 'admin_id', 'id');
    }

    public function myModel() {
        return $this->hasMany('App\Entities\MyModel', 'visit_id', 'id');
    }

}
