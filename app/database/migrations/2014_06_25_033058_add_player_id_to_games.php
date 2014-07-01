<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlayerIdToGames extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('games', function($table) {
			$table->integer('player_id')->unsigned();
			$table->foreign('player_id')->references('player_id')->on('players');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('games', function($table) {
			$table->dropForeign('games_player_id_foreign');
			$table->dropColumn('player_id');
		});
	}

}
