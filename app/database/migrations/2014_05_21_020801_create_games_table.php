<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('games', function(Blueprint $table)
		{
			$table->increments('game_id');
			$table->string('status');
			$table->integer('group_id')->unsigned();
			$table->foreign('group_id')->references('group_id')->on('groups');
			$table->integer('machine_id')->unsigned();
			$table->foreign('machine_id')->references('machine_id')->on('machines');
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
		Schema::drop('games');
	}

}
