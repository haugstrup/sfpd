<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodeIndexesForGamesAndGroup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('groups', function($table) {
			$table->unique('code');
		});
		Schema::table('games', function($table) {
			$table->unique('code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('groups', function($table) {
			$table->dropUnique('groups_code_unique');
		});
		Schema::table('games', function($table) {
			$table->dropUnique('games_code_unique');
		});
	}

}
