<?php

use App\Entities\Outlet;

function count_target_monthly_visits($fos, $date) {
    $tab_nom_jour = array('Monday' => 2, 'Tuesday' => 3, 'Wednesday' => 4, 'Thursday' => 5, 'Friday' => 6, 'Saturday' => 7, 'Sunday' => 1);
    $total = 0;
    $days[] = array();


    if (is_array($fos)) {
        foreach ($fos as $fo) {
            //tt les outlets d'un fo 

            $outlets = Outlet::where('admin_id', '=', $fo['id'])->where('active', '=', 1)->get();
            $target_meurch = 0;
            foreach ($outlets as $outlet) {

                $days = (json_decode($outlet['visit_day']));

                if (!empty($days)) {
                    $s = 0;
                    foreach ($days as $day) {
                        $numeroJour = $tab_nom_jour[$day];

                        $J1 = 1;
                        $M1 = date("n", strtotime($date));
                        $A1 = date("Y", strtotime($date));

                        $J2 = date('t', mktime(0, 0, 0, $M1, 1, $A1));
                        $M2 = date("n", strtotime($date));
                        $A2 = date("Y", strtotime($date));

                        $nbJour = 0;
                        $Date1 = mktime(0, 0, 0, $M1, $J1, $A1);
                        $Date2 = mktime(0, 0, 0, $M2, $J2, $A2);
                        $nbJourDiff = ($Date2 - $Date1) / (60 * 60 * 24);
                        for ($i = 0; $i < $nbJourDiff + 1; $i++) {
                            $Date1 = mktime(0, 0, 0, $M1, $J1 + $i, $A1);
                            if (date("w", $Date1) == $numeroJour - 1)
                                $nbJour++;
                        }
                        //echo $nbJour;
                        //chaque meurch chaque outlet
                        $s = $s + $nbJour;

                        //chaque meurch ces outlet
                        $target_meurch = $target_meurch + $nbJour;

                        //tt les meurch 
                        $total = $total + $nbJour;
                    }
                }
            }
        }
    }

    else {
        $outlets = Outlet::where('admin_id', '=', $fos)->where('active', '=', 1)->get();
        $target_meurch = 0;
        foreach ($outlets as $outlet) {

            $days = (json_decode($outlet['visit_day']));

            if (!empty($days)) {
                $s = 0;
                foreach ($days as $day) {
                    $numeroJour = $tab_nom_jour[$day];

                    $J1 = 1;
                    $M1 = date("n", strtotime($date));
                    $A1 = date("Y", strtotime($date));

                    $J2 = date('t', mktime(0, 0, 0, $M1, 1, $A1));
                    $M2 = date("n", strtotime($date));
                    $A2 = date("Y", strtotime($date));


                    $nbJour = 0;
                    $Date1 = mktime(0, 0, 0, $M1, $J1, $A1);
                    $Date2 = mktime(0, 0, 0, $M2, $J2, $A2);
                    $nbJourDiff = ($Date2 - $Date1) / (60 * 60 * 24);
                    for ($i = 0; $i < $nbJourDiff + 1; $i++) {
                        $Date1 = mktime(0, 0, 0, $M1, $J1 + $i, $A1);
                        if (date("w", $Date1) == $numeroJour - 1)
                            $nbJour++;
                    }
                    //echo $nbJour;
                    //chaque meurch chaque outlet
                    $s = $s + $nbJour;

                    //chaque meurch ces outlet
                    $target_meurch = $target_meurch + $nbJour;

                    //tt les meurch 
                    $total = $total + $nbJour;
                }
            }
        }
    }
    return $total;
}

function was_there($lat1, $lon1, $lat2, $lon2) {
    $r = 6371; // Radius of the earth in km
    $dLat = deg2rad1($lat2 - $lat1);  // deg2rad below
    $dLon = deg2rad1($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad1($lat1)) * cos(deg2rad1($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $d = $r * $c; // Distance in km
    if ($d <= 0.5) {
        return true;
    } else {
        return false;
    }
}

function deg2rad1($deg) {
    return $deg * (3.14 / 180);
}
