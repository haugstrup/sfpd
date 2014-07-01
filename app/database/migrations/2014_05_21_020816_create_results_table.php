<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('results', function(Blueprint $table)
		{
			$table->increments('result_id');
			$table->integer('game_id')->unsigned();
			$table->foreign('game_id')->references('game_id')->on('games');
			$table->integer('player_id')->unsigned();
			$table->foreign('player_id')->references('player_id')->on('players');
			$table->integer('position')->unsigned()->nullable();

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('results');
	}

}
