<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('format_time')) {

    function format_time($date) {
        if (empty($date)) {
            return;
        } else {
            return date('h:i:sa', strtotime($date));
        }
    }

}

function getStartAndEndDate($week, $year) {
    // Adding leading zeros for weeks 1 - 9.
    $date_string = $year . 'W' . sprintf('%02d', $week);
    $return[0] = date('Y-n-j', strtotime($date_string));
    $return[1] = date('Y-n-j', strtotime($date_string . '7'));
    return $return;
}

function format_quarter($date) {
    //2018-02-25  ==> 2018-Q1

    if (empty($date) || $date == '0000-00-00') {
        return '';
    } else {
        //return date('m', strtotime($date)) . '-' . date('Y', strtotime($date));
        $year = date('Y', strtotime($date));
        if ($date >= $year . '-01-01' && $date < $year . '-04-01') {
            return 'Q1-' . $year;
        } else if ($date >= $year . '-04-01' && $date < $year . '-07-01') {
            return 'Q2-' . $year;
        } else if ($date >= $year . '-07-01' && $date < $year . '-10-01') {
            return 'Q3-' . $year;
        } else {
            return 'Q4-' . $year;
        }
        // Q1-2017

        return '';
    }
}

function format_qmw_date($date_type, $date) {
    if ($date_type == 'month') {
        return format_month($date);
    } else if ($date_type == 'week') {
        return format_week($date);
    } else {
        return format_quarter($date);
    }
}

if (!function_exists('reverse_format')) {

    function reverse_format($date) {
        if (empty($date)) {
            return;
        }

        $d = explode('-', $date);

        return "{$d[2]}/{$d[1]}/{$d[0]}";
    }

}


if (!function_exists('format_week')) {

    function format_week($date) {
        if (empty($date) || $date == '0000-00-00') {
            return '';
        } else {
            return date('o', strtotime($date)) . '-W' . date('W', strtotime($date));
        }
    }

}


if (!function_exists('format_month')) {

    function format_month($date) {

        if (empty($date) || $date == '0000-00-00') {
            return '';
        } else {
            return date('m', strtotime($date)) . '-' . date('Y', strtotime($date));
        }
    }

}


if (!function_exists('firstDayOf')) {

    function firstDayOf($period, $str_date) {
//        echo gettype ( $str_date );
//        die();
        //die($str_date);
        //
        //die($date);
        if (is_object($str_date))
            $date = $str_date;
        else
            $date = new DateTime($str_date);


        $period = strtolower($period);
        $validPeriods = array('year', 'quarter', 'month', 'week');

        if (!in_array($period, $validPeriods))
            throw new InvalidArgumentException('Period must be one of: ' . implode(', ', $validPeriods));

        $newDate = ($date === null) ? new DateTime() : clone $date;

        switch ($period) {
            case 'year' :
                $newDate->modify('first day of january ' . $newDate->format('Y'));
                break;
            case 'quarter' :
                $month = $newDate->format('n');

                if ($month < 4) {
                    $newDate->modify('first day of january ' . $newDate->format('Y'));
                } elseif ($month > 3 && $month < 7) {
                    $newDate->modify('first day of april ' . $newDate->format('Y'));
                } elseif ($month > 6 && $month < 10) {
                    $newDate->modify('first day of july ' . $newDate->format('Y'));
                } elseif ($month > 9) {
                    $newDate->modify('first day of october ' . $newDate->format('Y'));
                }
                break;
            case 'month' :
                $newDate->modify('first day of this month');
                break;
            case 'week' :
                $newDate->modify(($newDate->format('w') === '0') ? 'monday last week' : 'monday this week');
                break;
        }

        return $newDate->format('Y-m-d');
    }

}