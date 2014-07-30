<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertActivityDataToText extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activities', function($table) {
			$table->dropColumn('data');
		});

		Schema::table('activities', function($table) {
			$table->text('data');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activities', function($table) {
			$table->dropColumn('data');
		});
		Schema::table('activities', function($table) {
			$table->string('data');
		});
	}

}
