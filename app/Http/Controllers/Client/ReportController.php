<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\ReportRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\SurveyRepository;
use Illuminate\Http\Request;
use Excel;

class ReportController extends Controller {

    protected $categoryRepository;
    protected $userRepository;
    protected $reportRepository;
    protected $surveyRepository;

    public function __construct(ReportRepository $reportRepository, UserRepository $userRepository, QuestionRepository $questionRepository, SurveyRepository $surveyRepository) {
        $this->userRepository = $userRepository;
        $this->reportRepository = $reportRepository;
        $this->questionRepository = $questionRepository;
        $this->surveyRepository = $surveyRepository;
    }

    public function index() {
        $title = 'Report';
        $subTitle = 'Report';
        return view('client.reports.index', compact('title', 'subTitle'));
    }

    //******************************************************//
    // Survey Summary Report
    public function survey(Request $request) {





        $title = 'Reports';
        $subTitle = 'Survey Report';
        $visits = array();
        $questions = array();


        $users = $this->userRepository->getUsersByRole('User', 1);
        $users = $users->pluck('name', 'id')->toArray();
        $users = array('-1' => "Please Select User") + $users;
        
        $surveys = $this->surveyRepository->getAll();
        $surveys = $surveys->pluck('title', 'id')->toArray();
      

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $user_id = $request->input('user_id');
        $survey_id = $request->input('survey_id');
        $excel = $request->input('excel');

        if ($start_date != '' && $end_date != '') {
            $survey = $this->surveyRepository->getById($survey_id);

            $questions = $survey->questions;
            
             //$questions =  array_merge (array('Chef Zone','Code Client','Gouvernorat','Delegation','Localite','Date'),$questions->pluck('question')->toArray() );
            $visits = $this->reportRepository->getVisits($start_date, $end_date, $user_id,$survey_id);
        }
        if ($excel == 0) {
            return view('client.reports.survey_report', compact('visits', 'questions', 'users','surveys', 'title', 'subTitle'));
        } else {
            $this->exportSurveys($visits, $questions);
        }
    }

    public function exportSurveys($visits = array(), $questions = array()) {
        set_time_limit(-1);
        // First row
        $first_row[]='Chef Zone';
        $first_row[]='Code Client';
        $first_row[]='Gouvernorat';
        $first_row[]='Delegation';
        $first_row[]='Localite';
        $first_row[]='Date';
        foreach ($questions as $question){
            $first_row[]=$question->question;
        }
        $survey_array[] = $first_row;
        // Others rows
        foreach($visits as $visit){
            $other_row=array();
            $other_row[]= $visit['chef_zone'];
            $other_row[]= $visit['code_client'];
            $other_row[]= $visit['gouvernorat'];
            $other_row[]= $visit['delegation'];
            $other_row[]= $visit['localite'];
            $other_row[]= $visit['date'];
            foreach($questions as $question){
                if(isset($visit['answers'][$question->id])){
                     $other_row[]= $visit['answers'][$question->id];
                }else{
                    $other_row[]='-';
                }
            }
            $survey_array[] = $other_row;
        }
               


        Excel::create('Surveys Report Data', function($excel) use ($survey_array) {
            $excel->setTitle('Surveys Report');
            $excel->sheet('surveys Data', function($sheet) use ($survey_array) {
                $sheet->fromArray($survey_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    //******************************************************//
    // Tracking Report

    function tracking(Request $request) {

        $title = 'Reports';
        $subTitle = 'Tracking Report ';

        $current_attendances = array();
        $summary_attendances = array();
       
        $survey_id = $request->input('sursvey_id');
        $by = $request->input('by');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

       
       $tracking_visits = $this->reportRepository->getTracking_visits($start_date, $end_date, $by, $survey_id);
       return view('client.reports.tracking_report', compact('start_date', 'end_date', 'tracking_visits', 'title', 'subTitle'));
        
    }

    public function exportAttendances($current_attendances = array(), $summary_attendances = array()) {
        set_time_limit(-1);
        $attendance_array = array();
        if (!empty($current_attendances)) {
            // First row
            $attendance_array[] = array('Date', 'Outlet', 'Promoter', 'Checkin Time', 'Checkout Time');
            // Others rows
            foreach ($current_attendances as $att) {
                $attendance_array[] = array(reverse_format($att['date']), $att['outlet_name'], $att['promoter_name'], $att['checkin_time'], $att['checkout_time']);
            }
        }
        if (!empty($summary_attendances)) {
            // First row
            $attendance_array[] = array('Outlet', 'Promoter', 'NB Days');
            // Others rows
            foreach ($summary_attendances as $att) {
                $attendance_array[] = array($att['outlet_name'], $att['promoter_name'], $att['nb_days']);
            }
        }


        Excel::create('Attendances Report', function($excel) use ($attendance_array) {
            $excel->setTitle('Attendances Report');
            $excel->sheet('Attendances Data', function($sheet) use ($attendance_array) {
                $sheet->fromArray($attendance_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

    //******************************************************//
    // Achievement Report

    public function achievement() {
        $title = 'Achievement';
        $subTitle = 'Report achievement';
        return view('client.reports.achievement_report', compact('title', 'subTitle'));
    }

}
