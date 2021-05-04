<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Email extends Model {

    protected $table = 'email';
    protected $fillable = ['id', 'message', 'date', 'responsible_id', 'responsible_email', 'outlet_id', 'outlet_name'];
    protected $primaryKey = 'id';
    public $timestamps = false;

}
