<?php

namespace App\Repositories;

use DB;

class UploadRepository extends ResourceRepository {

    public function __construct() {
        
    }

    public function getFiles($search = '') {

        $downloads = DB::table('downloads')->select('downloads.*')
                ->get();
        return $downloads;
    }

    public function addFile($save, $id = '') {

        if ($id == '') {
            $id = DB::table('downloads')->insertGetId(
                    $save
            );
        } else {
            DB::table('downloads')
                    ->where('downloads.id', $id)
                    ->update($save);
        }
        return $id;
    }

    public function deleteFile($id) {

        DB::table('downloads')->where('downloads.id', $id)->delete();
    }

    public function getFileById($id) {

        $file = File::select('downloads.*')
                ->where('downloads.id', $id)
                ->first();
        //dd($file);
        return $file;
    }

}
