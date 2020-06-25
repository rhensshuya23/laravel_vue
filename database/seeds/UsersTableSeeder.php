<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use  App\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        foreach(range(1,15) as $index) {
            $users = [
            [
                'name' => $faker->name,
                'position' => 'Registrar',
                'email' => $faker->email,
                'type' => 'registrar',
                'bio' => 'I will do what is right.',
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at'     => '2019-09-13 19:21:30',
                'updated_at'     => '2019-09-13 19:21:30',
            ]
          ];
          User::insert($users);
        };

        $users = [

            [
                'name' => 'Rhens',
                'position' => 'Manager',
                'email' => 'admin@gmail.com',
                'type' => 'admin',
                'bio' => 'I am the one who managed this system.',
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at'     => '2019-09-13 19:21:30',
                'updated_at'     => '2019-09-13 19:21:30',
            ],

        	[
        		'name' => 'Abdullah Abdulazis',
	        	'position' => 'Developer',
	        	'email' => 'rhens@gmail.com',
	        	'type' => 'super_admin',
	        	'bio' => 'I am the one who developed this system.',
	        	'password' => Hash::make('nanahara23'),
	        	'remember_token' => null,
                'created_at'     => '2019-09-13 19:21:30',
                'updated_at'     => '2019-09-13 19:21:30',
        	],

        	[
        		'name' => 'Abdullah Abdulazis',
	        	'position' => 'Owner',
	        	'email' => 'user@gmail.com',
	        	'type' => 'registrar',
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
