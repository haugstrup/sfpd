<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsToSeasons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('seasons', function($table) {
			$table->integer('game_count')->unsigned()->nullable();
			$table->integer('adjust_points')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('seasons', function($table) {
			$table->dropColumn('game_count');
			$table->dropColumn('adjust_points');
		});
	}

}
