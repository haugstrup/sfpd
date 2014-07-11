<?php

class SeasonsTableSeeder extends Seeder {

	public function run()
	{

    DB::table('seasons')->truncate();

    Season::create(array(
      'name' => 'Fall 2014',
      'status' => 'active',
      'points_map' => '{4:{1:4.5,2:3,3:2,4:1},3{1:4.5,2:2.5,3:1,4:0}}'
    ));

	}

}
