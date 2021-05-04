<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\VisitRepository;
use App\Repositories\SurveyRepository;
use App\Repositories\VisitAnswerRepository;
use App\Repositories\ClientRepository;
use App\Repositories\VisitUploadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Session;
use Auth;

class VisitController extends Controller {

    protected $visitRepository;
    protected $surveyRepository;
    protected $visitAnswerRepository;
    protected $visitUploadRepository;
    protected $clientRepository;
    private $photos_path;

    public function __construct(VisitRepository $visitRepository, SurveyRepository $surveyRepository, VisitAnswerRepository $visitAnswerRepository
    , ClientRepository $clientRepository, VisitUploadRepository $visitUploadRepository) {
        $this->visitRepository = $visitRepository;
        $this->surveyRepository = $surveyRepository;
        $this->visitAnswerRepository = $visitAnswerRepository;
        $this->clientRepository = $clientRepository;
        $this->visitUploadRepository = $visitUploadRepository;

        $this->photos_path = public_path('/uploads');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = 'Survey Visits';
        $subTitle = 'List of Survey Visits';
        $user_id = Auth::user()->id;
        $visits = $this->visitRepository->getVisits(20, $user_id);
        $links = $visits->setPath('')->render();
        return view('user.visits.index', compact('title', 'subTitle', 'visits', 'links'));
    }

    public function visitsBySurvey($survey_id) {
        $title = 'Survey Visits';
        $subTitle = 'List of Survey Visits';
        $user_id = Auth::user()->id;
        $visits = $this->visitRepository->getVisits(20, $user_id, $survey_id);
        $links = $visits->setPath('')->render();
        return view('user.visits.index', compact('title', 'subTitle', 'visits', 'links'));
    }

    public function deleteVisit($visit_id) {
        $this->visitRepository->destroy($visit_id);
        request()->session()->flash('message', 'Visit has been deleted successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.dashboard');
    }

    public function create($survey_id) {
        $title = 'Survey Visits';
        $subTitle = 'Survey Visit Form';

        // Create new visit
        $save['user_id'] = Auth::user()->id;
        $save['date'] = date('Y-m-d');
        $save['survey_id'] = $survey_id;
        $save['description'] = '';
        $visit = $this->visitRepository->store($save);

        $inserted_visit_id = $visit->id;

        // Retrieve questions of requested survey
        $survey = $this->surveyRepository->getById($survey_id);
        $questions = $survey->questions;
        foreach ($questions as $question) {
            $save_answer['visit_id'] = $inserted_visit_id;
            $save_answer['question_id'] = $question->id;
            $save_answer['radio_value'] = 0;
            $save_answer['checkbox_value'] = '[]';
            $save_answer['text_value'] = '';
            $this->visitAnswerRepository->store($save_answer);
        }

        // Retrieve inserted answers
        //$answers=$this->visitAnswerRepository->getVisitAnswers($inserted_visit_id);
        $answers = $visit->answers;
        // return view('user.visits.edit', compact('title', 'subTitle','answers', 'visit'));
        return redirect()->route('user.visit.edit', $inserted_visit_id);
    }

    public function edit($visit_id) {
        $title = 'Survey Visits';
        $subTitle = 'Survey Visit Form';
        $user_id = Auth::user()->id;
        $clients = $this->clientRepository->getClients($user_id, "-1", "-1", "-1");
        $clients = $clients->pluck('code_client', 'id')->toArray();
        $clients = array('-1' => "Please Select Client") + $clients;

        $gouvernorats = $this->clientRepository->getGouvernorats($user_id);
        $gouvernorats = $gouvernorats->pluck('gouvernorat', 'gouvernorat')->toArray();
        $gouvernorats = array('-1' => "Please Select Gouvrernorat") + $gouvernorats;


        $visit = $this->visitRepository->getById($visit_id);
        // Retrieve inserted answers
        $answers = $visit->answers;
        
        // Retrieve related pics		
        $pics = $this->visitUploadRepository->getImagesByVisit($visit_id);
        
        return view('user.visits.edit', compact('title', 'subTitle', 'clients', 'gouvernorats', 'answers', 'visit','pics'));
    }

    public function updateAnswer(Request $request) {
        if ($request->type == 'Checkbox') {
            $save['checkbox_value'] = $request->checkbox_value;
        } else if ($request->type == 'Radio') {
            $save['radio_value'] = $request->radio_value;
        } else {
            $save['text_value'] = $request->text_value;
        }
        //print_r($save);die();
        $this->visitAnswerRepository->update($request->answer_id, $save);
    }

    public function updateVisit(Request $request) {
        //update visit
        $save['client_id'] = $request->client_id;
        $this->visitRepository->update($request->visit_id, $save);
    }

    public function updateClient($visit_id) {
        $visit = $this->visitRepository->getById($visit_id);
        //update client active
        if (isset($visit->client->id)) {
            $save_client['active'] = 1;
            $this->clientRepository->update($visit->client->id, $save_client);
        }
        return redirect()->route('user.dashboard');
    }

    public function getDelegations(Request $request) {
        $user_id = Auth::user()->id;
        $gouv_name = $request->gouv_name;
        $delegations = $this->clientRepository->getDelegations($user_id, $gouv_name);
        $delegations = $delegations->pluck('deleg_name', 'deleg_name')->toArray();
        $delegations = array('-1' => "Please Select Delegation") + $delegations;
        return $delegations;
    }

    public function getLocalites(Request $request) {
        $user_id = Auth::user()->id;
        $deleg_name = $request->deleg_name;
        $localites = $this->clientRepository->getLocalites($user_id, $deleg_name);
        $localites = $localites->pluck('localite_name', 'localite_name')->toArray();
        $localites = array('-1' => "Please Select Localite") + $localites;
        return $localites;
    }

    public function getClients(Request $request) {
        $user_id = Auth::user()->id;
        $localite_name = $request->localite_name;
        $gouv_name = $request->gouv_name;
        $deleg_name = $request->deleg_name;
        $clients = $this->clientRepository->getClients($user_id, $gouv_name, $deleg_name, $localite_name);
        $clients = $clients->pluck('code_client', 'id')->toArray();
        $clients = array('0' => " Please Select Client") + $clients;

        // krsort($clients);
        return $clients;
    }

    public function uploadPhotos(Request $request, $visit_id) {
        $photos = $request->file('file');

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $name = date('Y') . '-' . time();
            $save_name = $name . '.' . $photo->getClientOriginalExtension();
            $photo->move($this->photos_path, $save_name);

            $save['visit_id'] = $visit_id;
            $save['filename'] = $save_name;
            $this->visitUploadRepository->store($save);
        }
        return Response::json([
                    'message' => 'Image saved Successfully'
                        ], 200);
    }

    public function removePhotos(Request $request,$visit_id) {
        $filename = $request->id;
       
        //$uploaded_image = Upload::where('original_name', basename($filename))->first();
       
        $uploaded_image = $this->visitUploadRepository->getImageByFileName($filename);
    
        if (empty($uploaded_image->toArray())) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }

        $file_path = $this->photos_path . '/' . $filename;

        
        if (file_exists($file_path)) {
            unlink($file_path);
        }


        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }

        return Response::json(['message' => 'File successfully delete'], 200);
    }

    public function show(Request $request, $visit_id) {

         $images = $this->visitUploadRepository->getImagesByVisit($request->visit_id);

        $imageAnswer = [];

        foreach ($images as $image) {
            $imageAnswer[] = [
                'filename' => $image->filename,
                'size' => File::size(public_path('uploads/' . $image->filename))
            ];
        }

        return response()->json([
            'images' => $imageAnswer
        ]);
    }

}
