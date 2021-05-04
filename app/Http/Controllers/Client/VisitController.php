<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Repositories\VisitRepository;
use App\Repositories\SurveyRepository;
use App\Repositories\VisitAnswerRepository;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Session;
use Auth;

class VisitController extends Controller {

     protected $visitRepository;
    protected $surveyRepository;
    protected $visitAnswerRepository;
    protected $clientRepository;

    public function __construct(VisitRepository $visitRepository, SurveyRepository $surveyRepository,
            VisitAnswerRepository $visitAnswerRepository
    , ClientRepository $clientRepository) {
        $this->visitRepository = $visitRepository;
        $this->surveyRepository = $surveyRepository;
        $this->visitAnswerRepository = $visitAnswerRepository;
        $this->clientRepository = $clientRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = 'Visits';
        $subTitle = 'List of visits';
        $visits = $this->visitRepository->getVisits(20);
      //  dd($visits);
        $links = $visits->setPath('')->render();
        return view('client.visits.index', compact('title', 'subTitle', 'links', 'visits'));
    }

  
      public function edit($visit_id) {
        $title = 'Survey Visits';
        $subTitle = 'Survey Visit Form';
        $user_id = Auth::user()->id;
        $clients = $this->clientRepository->getClients("-1","-1","-1", "-1");
        $clients = $clients->pluck('code_client', 'id')->toArray();
        $clients = array('-1' => "Please Select Client") + $clients;

        $gouvernorats = $this->clientRepository->getGouvernorats("-1");
        $gouvernorats = $gouvernorats->pluck('gouvernorat', 'gouvernorat')->toArray();
        $gouvernorats = array('-1' => "Please Select Gouvrernorat") + $gouvernorats;


        $visit = $this->visitRepository->getById($visit_id);
        // Retrieve inserted answers
        $answers = $visit->answers;
        return view('client.visits.edit', compact('title', 'subTitle', 'clients', 'gouvernorats', 'answers', 'visit'));
    }
     public function show($visit_id) {
        $title = 'Survey Visits';
        $subTitle = 'Survey Visit Report';

        $visit = $this->visitRepository->getById($visit_id);
        // Retrieve inserted answers
        $answers = $visit->answers;
        return view('client.visits.show', compact('title', 'subTitle', 'answers', 'visit'));
    }
    
     public function destroy($id) {
        $this->visitRepository->destroy($id);
        request()->session()->flash('message', 'Visit has been deleted successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('client.visit.index');
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
        if(isset($visit->client->id)){
        $save_client['active'] = 1;
        $this->clientRepository->update($visit->client->id, $save_client);
        }
        return redirect()->route('client.dashboard');
    }

    public function getDelegations(Request $request) {
        $user_id = Auth::user()->id;
        $gouv_name = $request->gouv_name;
        $delegations = $this->clientRepository->getDelegations("-1", $gouv_name);
        $delegations = $delegations->pluck('deleg_name', 'deleg_name')->toArray();
        $delegations = array('-1' => "Please Select Delegation") + $delegations;
        return $delegations;
    }

    public function getLocalites(Request $request) {
        $user_id = Auth::user()->id;
        $deleg_name = $request->deleg_name;
        $localites = $this->clientRepository->getLocalites("-1", $deleg_name);
        $localites = $localites->pluck('localite_name', 'localite_name')->toArray();
        $localites = array('-1' => "Please Select Localite") + $localites;
        return $localites;
    }

    public function getClients(Request $request) {
        $user_id = Auth::user()->id;
        $localite_name = $request->localite_name;
        $gouv_name = $request->gouv_name;
        $deleg_name = $request->deleg_name;
        $clients = $this->clientRepository->getClients("-1",$gouv_name,$deleg_name, $localite_name);
        $clients = $clients->pluck('code_client', 'id')->toArray();
        $clients = array('0' => " Please Select Client") + $clients;
     
       // krsort($clients);
        return $clients;
    }



}
