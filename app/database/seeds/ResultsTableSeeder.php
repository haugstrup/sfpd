<?php

class ResultsTableSeeder extends Seeder {

	public function run()
	{

    DB::table('results')->truncate();

    Result::create(array(
      'game_id' => 1,
      'player_id' => 1,
      'position' => 1,
      'delta' => 0,
    ));

    Result::create(array(
      'game_id' => 1,
      'player_id' => 2,
      'position' => 2,
      'delta' => 1,
    ));

    Result::create(array(
      'game_id' => 1,
      'player_id' => 2,
      'position' => 3,
      'delta' => 2,
    ));

	}

}
