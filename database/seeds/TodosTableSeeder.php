<?php

use Illuminate\Database\Seeder;
use App\Todo;
use Faker\Factory as Faker;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1,10) as $index) {
            $todos = [
            [
            	'user_id' => 16,
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'completed' => 0
            ]
          ];
          Todo::insert($todos);
        };
    }
}
