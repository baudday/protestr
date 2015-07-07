<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('TopicTableSeeder');
		$this->call('ProtestTableSeeder');
		$this->call('ProtestUserTableSeeder');
		$this->call('CommentTableSeeder');
		$this->call('UpdateTableSeeder');
	}

}
