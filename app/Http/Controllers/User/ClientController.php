<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Session;
use Excel;
use Auth;

class ClientController extends Controller {

    protected $clientRepository;
    protected $userRepository;
    
    public function __construct(ClientRepository $clientRepository, UserRepository $userRepository) {
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title = 'Clients';
        $subTitle = 'List of clients';
        if ($request->isMethod('post')) {
            $search = $request->input('search');
        } else {
            $search = '';
        }
        
        $clients = $this->clientRepository->getAllClients(20, $search);
        //dd($clients);
        $links = $clients->setPath('')->render();
        return view('user.clients.index', compact('clients', 'links', 'title', 'subTitle'));
    }

    public function create() {        
        $title = 'Clients';
        $subTitle = 'Client Form';            
    // Get the currently authenticated user...
        $user = Auth::user()->name;
        return view('user.clients.create', compact('title', 'subTitle','user'));
    }

    public function store(Request $request) {
       // dd($request);
        $this->validate($request, [
  
            'gouvernorat' => 'required|string|max:255',
            'delegation' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
            'code_client' => 'required|string|max:255',
            
        ]);
        // Get the currently authenticated user's ID...
        $id = Auth::id();
        $save['chef_zone'] = $request->chef_zone;
        $save['gouvernorat'] = $request->gouvernorat;
        $save['delegation'] = $request->delegation;
        $save['localite'] = $request->localite;
        $save['code_client'] = $request->code_client;
        $save['user_id'] = $id;
        $save['active'] = 0;

        $this->clientRepository->store($save);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'Client has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('user.dashboard');
    }

    public function show($id) {
        $user = $this->clientRepository->getById($id);

        return view('user.client.show', compact('user'));
    }

    public function edit($id) {
        $title = 'Clients';
        $subTitle = 'Client Form';
        $users = $this->userRepository->getUsersByRole('User', 1);
        $users = $users->pluck('name', 'id')->toArray();
        $users = array('-1' => "Please Select User") + $users;
        $client = $this->clientRepository->getById($id);
        
        return view('user.clients.edit', compact('client', 'users', 'title', 'subTitle'));
    }

    public function update(Request $request, $id) {
         $this->validate($request, [
        
            'gouvernorat' => 'required|string|max:255',
            'delegation' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
            'code_client' => 'required|string|max:255',
            
        ]);

        $save['chef_zone'] = $request->chef_zone;
        $save['gouvernorat'] = $request->gouvernorat;
        $save['delegation'] = $request->delegation;
        $save['localite'] = $request->localite;
        $save['code_client'] = $request->code_client;
        $save['user_id'] = $request->user_id;
        $save['active'] = 0;


        $this->clientRepository->update($id, $save);

        request()->session()->flash('message', 'Client has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('user.client.index');
    }
    
      public function enable($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->clientRepository->update($id, $save);
        request()->session()->flash('message', 'Client has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('user.client.index');
    }

    public function disable($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->clientRepository->update($id, $save);
        request()->session()->flash('message', 'Client has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('user.client.index');
    } 
    

   public function export() {
       
       $clients_data = $this->clientRepository->getAll();    
      
       $client_array[] = array('User', 'Gouvernorat', 'Delegation', 'Localite', 'Code client');
       
       foreach ($clients_data as $client) {

            $client_array[] = array( 
                'User' => $client->user->name,
                'Gouvernorat' => $client->gouvernorat,
                'Delegation' => $client->delegation,
                'Localite' => $client->localite,
                'Code client' => $client->code_client,              
            );
        
        }
        
        Excel::create('Clients Data', function($excel) use ($client_array) {
            $excel->setTitle('Sales Data');
            $excel->sheet('Clients Data', function($sheet) use ($client_array) {
                $sheet->fromArray($client_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }
}
