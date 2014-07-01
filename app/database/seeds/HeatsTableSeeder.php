<?php

class HeatsTableSeeder extends Seeder {

	public function run()
	{

    DB::table('heats')->truncate();

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-07-16 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 0
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-07-30 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'active',
      'season_id' => 1,
      'date' => $date,
      'delta' => 1
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-08-06 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 2
    ));

	}

}
