<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use  App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        	[
        		'name' => 'Rhens Shuya',
	        	'position' => 'Manager',
	        	'email' => 'admin@gmail.com',
	        	'type' => 'admin',
	        	'bio' => 'I am the one who manages this system.',
	        	'password' => Hash::make('password'),
	        	'remember_token' => null,
                'created_at'     => '2019-09-13 19:21:30',
                'updated_at'     => '2019-09-13 19:21:30',
        	],

        	[
        		'name' => 'Rhens Unda',
	        	'position' => 'Employee',
	        	'email' => 'user@gmail.com',
	        	'type' => 'user',
	        	'bio' => 'I will do what is right!',
	        	'password' => Hash::make('password'),
	        	'remember_token' => null,
                'created_at'     => '2019-09-13 19:21:30',
                'updated_at'     => '2019-09-13 19:21:30',
        	]
        ];

        User::insert($users);
    }
}
