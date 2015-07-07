<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class ProtestUserTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $users = User::all();

		foreach ($users as $user) {
            $protest = Protest::orderByRaw("RAND()")->first();
            $protest->attendees()->attach($user->id);
        }
	}

}
