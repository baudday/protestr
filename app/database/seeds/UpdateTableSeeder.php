<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class UpdateTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $protests = Protest::all();

        foreach ($protests as $protest) {
    		foreach(range(1, rand(1, 5)) as $index)
    		{
    			Update::create([
                    'protest_id' => $protest->id,
                    'title' => $faker->sentence,
                    'body' => $faker->paragraph
    			]);
    		}
        }
	}

}
