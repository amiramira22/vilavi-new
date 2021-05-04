<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::insert([
            'role_id' => 2,
            'active' => 1,
            'name' => 'user',
            'username' => 'user',
            'email' => 'user@mail.com',
            'password' => sha1('123456'),
            'remember_token' => str_random(10),
        ]);
         User::insert([
            'role_id' => 1,
            'active' => 1,
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => sha1('123456'),
            'remember_token' => str_random(10),
        ]);
        
        
    }

}
