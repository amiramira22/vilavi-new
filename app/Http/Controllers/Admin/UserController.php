<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\OutletRepository;
use Illuminate\Http\Request;
use App\Entities\Outlet;
use Session;
use Excel;
use DateTime;


class UserController extends Controller {

    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
         parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = 'Users';
        $subTitle = 'List of users';
        $users = $this->userRepository->getUsers();
        //$links = $users->setPath('')->render();
        //$users = $this->userRepository->getUsers();
        //dd($users);

        return view('admin.users.index', compact('users', 'title', 'subTitle'));
    }

    public function messages() {
        $title = 'Messages';
        $subTitle = 'Manage Messages';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;
        
        $fos = $this->userRepository->getUsersByRole('Field Officer');
        $fos = $fos->pluck('name', 'id');
        $data['fos'] = $fos;

        $connected_user_id = request()->session()->get('connected_user_id');
        $data['messages'] = $this->userRepository->getMessagesByUser($connected_user_id);
        //dd( $data['messages']);
        //dd( $data['messages']);
        return view('admin.users.messages', $data);
    }

    public function add_message() {
        $title = 'Messages';
        $subTitle = 'Create New Message';
        $data['title'] = $title;
        $data['subTitle'] = $subTitle;

        //$users = $this->userRepository->getUsers();
        //$links = $users->setPath('')->render();
        //$users = $this->userRepository->getUsers();
        //dd($users);

        return view('admin.users.add_message', $data);
    }

    public function postMessage(Request $request) {

        $fo_ids = $request->input('fo_ids');
        //$fo_ids = json_encode($fo_ids);
        $msg = $request->input('message');
        preg_match_all('|<[^>]+>(.*)</[^>]+>|U', $msg, $newmsg);
        //dd($fo_ids, $newmsg[1][0]);

        $save['sender_id'] = request()->session()->get('connected_user_id');
        $save['message'] = $newmsg[1][0];
        foreach ($fo_ids as $id) {
            $save['receiver_id'] = $id;
            $this->userRepository->save_msg($save);
        }

        request()->session()->flash('message', 'Message has been sent successfully.');
        return redirect()->route('admin.user.messages');
    }

    public function delete_message($id) {
        $this->userRepository->delete_message($id);
        request()->session()->flash('message', 'Message has been deleted successfully.');
        return redirect()->route('admin.user.messages');
    }

    public function create() {
        $title = 'Users';
        $subTitle = 'User Form';
        $roles = array('Admin' => 'Admin'
        , 'Field Officer' => 'Field Officer'
        , 'Client' => 'Client'
        , 'Responsible' => 'Responsible'

        );


        return view('admin.users.create', compact('roles', 'title', 'subTitle'));
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin',
            'username' => 'required|string|max:255|unique:admin',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $save['name'] = $request->name;
        $save['username'] = $request->username;
        $save['email'] = $request->email;
        $save['password'] = sha1($request->password);
        $save['access'] = $request->access;
        $save['active'] = 1;

        if ($request->photo) {
            $photo = $request->photo;
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path('users'), $filename);
            $save['photo'] = $filename;
        }

        $this->userRepository->store($save);
        // Store data for only a single request and destory
        request()->session()->flash('message', 'User has been saved successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.user.index');
    }

    public function show($id) {
        $user = $this->userRepository->getById($id);

        return view('admin.users.show', compact('user'));
    }

    public function edit($id) {
        $title = 'Users';
        $subTitle = 'User Form';
        $roles = array('Admin' => 'Admin', 'Field Officer' => 'Field Officer', 'Client' => 'Client', 'Responsible' => 'Responsible');
        $user = $this->userRepository->getById($id);

        return view('admin.users.edit', compact('user', 'roles', 'title', 'subTitle'));
    }

    public function update(Request $request, $id) {
        //$this->setAdmin($request);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $save['name'] = $request->name;
        $save['username'] = $request->username;
        $save['email'] = $request->email;
        $save['password'] = sha1($request->password);
        $save['pwd'] = $request->password;
        $save['access'] = $request->access;

        if ($request->photo) {
            $photo = $request->photo;
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path('users'), $filename);
            $save['photo'] = $filename;
        }
        $this->userRepository->update($id, $save);

        request()->session()->flash('message', 'User has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.user.index');
    }

    public function enable($id) {
        $save['id'] = $id;
        $save['active'] = 1;
        $this->userRepository->update($id, $save);
        request()->session()->flash('message', 'User has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.user.index');
    }

    public function disable($id) {
        $save['id'] = $id;
        $save['active'] = 0;
        $this->userRepository->update($id, $save);
        request()->session()->flash('message', 'User has been updated successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.user.index');
    }

    public function destroy($id) {
        $this->userRepository->destroy($id);
        request()->session()->flash('message', 'User has been deleted successfully.');
        // Redirect to `user.index` route
        // Use route:list to view the `Action` or where this routes going to
        return redirect()->route('admin.user.index');
    }

    function excel() {
        $user_data = $this->userRepository->getUsers(20);
        $user_array[] = array('Name', 'Username', 'Password', 'Access');
        foreach ($user_data as $user) {

            $user_array[] = array(
                'name' => $user->name,
                'username' => $user->username,
                'Password' => $user->pwd,
                'access' => $user->access
            );
        }
        Excel::create('User Data', function($excel) use ($user_array) {
            $excel->setTitle('User Data');
            $excel->sheet('User Data', function($sheet) use ($user_array) {
                $sheet->fromArray($user_array, null, 'A1', false, false);
            });
        })->download('xlsx');
    }

}
