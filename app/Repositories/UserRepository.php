<?php

namespace App\Repositories;

use App\Entities\User;
use DB;

class UserRepository extends ResourceRepository {

    public function __construct(User $user) {
        $this->model = $user;
    }

    function getResponsibleList() {

        $responsibles = User::select('admin.*')
                ->where('access', 'like', 'Responsible%')
                ->where('active', 1)
                ->orderBy('id', 'DESC')
                ->get();
        return $responsibles;
    }

    public function getUsers() {

        $admin = User::select('admin.*')
                ->orderBy('id', 'DESC')
//                ->orderBy('id', 'DESC')
//                ->paginate($n);
                ->get();

        return $admin;
    }

    public function getUsersByRole($role = 'Admin', $active = 1) {
        $admin = User::where('admin.active', $active)
                ->where('admin.access', $role)
                ->orderBy('admin.name')
                ->get();

        return $admin;
    }

    public function getFosList() {

        $admin = User::select('admin.*')
                ->orderBy('id', 'DESC')
//                ->orderBy('id', 'DESC')
//                ->paginate($n);
                ->get();
        return $admin;
    }

    public function getMessagesByUser($user_id) {
        $messages = DB::table('messages')
                ->select('messages.*'
                        , DB::raw('CAST(cos_messages.created as DATE) as created_date')
                        , DB::raw('CAST(cos_messages.created as TIME) as created_time'))
                ->leftjoin('admin', 'messages.sender_id', '=', 'admin.id')
                ->where('admin.id', '=', $user_id)
                ->orderBy('id', 'DESC')
                ->get();
        return $messages;
    }

    public function save_msg($save) {
        DB::table('messages')
                ->insert($save);
    }

    public function delete_message($id) {
        DB::table('messages')
                ->where('id', '=', $id)
                ->delete();
    }

}
