<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class FoPerformance extends Model {

    protected $table = 'fo_performance';
    protected $fillable = ['id', 'date', 'w_date', 'm_date', 'admin_id', 'working_hours', 'travel_hours', 'Monoprix', 'UHD', 'MG',
        'Traditional_Trade', 'Uni_Market', 'Nawara_Market'
        , 'Carrefour_Hyper', 'Geant', 'entry_time', 'exit_time', 'entry', 'exit', 'total_branding', 'nb_visits', 'was_there'];
    protected $primaryKey = 'id';
    public $timestamps = true;

}
