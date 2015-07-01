<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;

class TopicTableSeeder extends Seeder {

	public function run()
	{
        $topics = [
            "Animals",
            "Criminal Justice",
            "Economic Justice",
            "Education",
            "Environment",
            "Gay Rights",
            "Health",
            "Human Rights",
            "Human Trafficking",
            "Immigrant Rights",
            "Sustainable Food",
            "Women's Rights"
        ];

		foreach($topics as $topic)
		{
            $slug = strtolower(str_replace("'","", str_replace(' ', '-', $topic)));
			Topic::create([
                'name' => $topic,
                'slug' => $slug
			]);
		}
	}

}
