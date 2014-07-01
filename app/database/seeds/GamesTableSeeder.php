<?php

class GamesTableSeeder extends Seeder {

	public function run()
	{

    DB::table('games')->truncate();

    Game::create(array(
      'status' => 'completed',
      'group_id' => 1,
      'machine_id' => 1,
      'player_id' => 3,
    ));

    Game::create(array(
      'status' => 'active',
      'group_id' => 1,
      'machine_id' => 2,
      'player_id' => 3,
    ));

	}

}
