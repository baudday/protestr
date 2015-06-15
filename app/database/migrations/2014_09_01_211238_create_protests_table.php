<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('protests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->references('id')->on('users');
			$table->string('mission')->index();
			$table->string('type')->index();
			$table->text('history');
			$table->text('plan');
			$table->string('website');
			$table->string('address');
			$table->string('city')->index();
			$table->string('state')->index();
			$table->string('country')->index();
			$table->date('when_date')->index();
			$table->time('when_time')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('protests');
	}

}
