<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $table = 'messages';
    protected $fillable = ['id', 'sender_id', 'receiver_id', 'message', 'viewed', 'created'];
    protected $primaryKey = 'id';
    public $timestamps = false;

}
