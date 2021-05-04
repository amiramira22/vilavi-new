<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ResponsibleOrder extends Model {

    protected $table = 'responsible_order';
    protected $fillable = [
        'id', 'visit_id', 'file_name', 'random_file_name'
    ];
    protected $primaryKey = 'id';
    public $timestamps = true;


}
