<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionGuestRookieColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('player_season', function($table) {
			$table->integer('final_position')->unsigned()->nullable();
			$table->integer('rookie')->default(false);
			$table->integer('guest')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('player_season', function($table) {
			$table->dropColumn('final_position');
			$table->dropColumn('rookie');
			$table->dropColumn('guest');
		});
	}

}
