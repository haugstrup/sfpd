<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupPlayerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_player', function(Blueprint $table) {
			$table->integer('group_id')->unsigned()->index();
			$table->foreign('group_id')->references('group_id')->on('groups')->onDelete('cascade');
			$table->integer('player_id')->unsigned()->index();
			$table->foreign('player_id')->references('player_id')->on('players')->onDelete('cascade');
			$table->timestamps();

			$table->primary(array('group_id', 'player_id'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_player');
	}

}
