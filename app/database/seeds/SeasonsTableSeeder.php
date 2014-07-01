<?php

class SeasonsTableSeeder extends Seeder {

	public function run()
	{

    DB::table('seasons')->truncate();

    Season::create(array(
      'name' => 'Fall 2014',
      'status' => 'active'
    ));

	}

}
