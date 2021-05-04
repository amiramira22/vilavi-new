<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class HaProduct extends Model {

    protected $table = 'ha';
    protected $fillable = ['id', 'product_id', 'outlet_id'];
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}


?>
