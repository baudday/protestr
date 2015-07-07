<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 100) as $index)
		{
			User::create([
                'username' => $faker->userName,
                'email' => $faker->email,
                'password' => '1234'
			]);
		}
	}

}
