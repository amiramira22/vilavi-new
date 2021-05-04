<?php

//pharmacie

namespace App\Repositories;

use App\Entities\OutletsPhoto;
use DB;

class OutletPhotoRepository extends ResourceRepository {

    public function __construct(OutletsPhoto $outletPhoto) {
        $this->model = $outletPhoto;
    }

    public function getOutletPhotos() {

        $outlets_photos = OutletPhoto::select('outlets_photos.*')
                ->leftjoin('outlets', 'outlets.id', '=', 'outlets_photos.outlet_id')
                ->orderBy('name')
                ->get();
        //  dd($outlets);
        return $outlets_photos;
    }

    public function addOutletPhoto($save) {

        DB::table('outlets_photos')->insert(
                $save
        );
    }

    public function deleteOutletPhoto($id) {

        DB::table('outlets_photos')->where('outlets_photos.id', $id)->delete();
    }

}
