<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('heats', function(Blueprint $table)
		{
			$table->increments('heat_id');
			$table->string('status');
			$table->integer('season_id')->unsigned();
			$table->foreign('season_id')->references('season_id')->on('seasons');
			$table->dateTime('date');
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
		Schema::drop('heats');
	}

}
