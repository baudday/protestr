<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLongColumnsToProtestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('protests', function(Blueprint $table)
		{
			$table->double('latitude')->index();
			$table->double('longitude')->index();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('protests', function()
		{
			$table->dropColumn('latitude');
			$table->dropColumn('longitude');
		});
	}

}
