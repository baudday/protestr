<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class ProtestTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $users = User::all();
        $topics = Topic::all()->toArray();
        $types = [
            'Boycott' => 'Boycott',
            'Civil Disobedience' => 'Civil Disobedience',
            'March' => 'March'
        ];
        $nextYear = time() + (356*24*60*60);

		foreach(range(1, 5) as $index)
		{
            foreach ($users as $user) {
                $topic = $topics[array_rand($topics)];

    			Protest::create([
                    'user_id' => $user->id,
                    'mission' => $faker->sentence,
                    'type' => $types[array_rand($types)],
                    'topic_id' => $topic['id'],
                    'history' => $faker->paragraph,
                    'plan' => $faker->paragraph,
                    'website' => $faker->url,
                    'address' => $faker->streetAddress,
                    'city' => $faker->city,
                    'state' => $faker->stateAbbr,
                    'country' => 'US',
                    'when_date' => $faker->dateTimeBetween('now', $nextYear),
                    'when_time' => $faker->time(),
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude
    			]);
            }
		}
	}

}
