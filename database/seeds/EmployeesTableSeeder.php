<?php

use Illuminate\Database\Seeder;
use  App\Employee;
use Faker\Factory as Faker;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1,18) as $index) {
            $employees = [
            [
                'full_name' => $faker->name,
                'age' => $faker->randomElement([23, 19, 25,19, 20, 31]),
                'contact_no' => $faker->randomElement([
                	"09567098548", 
                	"09115687952", 
                	"06467484999"
                ]),
                'address' => $faker->address,
                'status' => $faker->randomElement(['Single', 'Married', 'Widow']),
                'salary' => $faker->randomElement([25000, 26000, 31000, 20000]),
                'position' => $faker->randomElement([
                	'English Teacher', 
                	'Math Teacher', 
                	'Science Teacher'
                ]),
                'email' => $faker->email,
                'user_id'     => 16,
                'user_name'     => "Rhens Shuya"
            ]
          ];
          Employee::insert($employees);
        };
    }
}
