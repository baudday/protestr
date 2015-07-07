<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class CommentTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $protests = Protest::all();

		foreach($protests as $protest)
		{
            foreach(range(1, rand(1, 5)) as $index)
            {
                $user = User::orderByRaw("RAND()")->first();
    			Comment::create([
                    'user_id' => $user->id,
                    'protest_id' => $protest->id,
                    'body' => $faker->text
    			]);
            }
		}
	}

}
