<?php

class HeatsTableSeeder extends Seeder {

	public function run()
	{

    DB::table('heats')->truncate();

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-07-30 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'active',
      'season_id' => 1,
      'date' => $date,
      'delta' => 0
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-08-06 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 1
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-08-20 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 2
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-09-03 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 3
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-09-17 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 4
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-10-01 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 5
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-10-15 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 6
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-10-29 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 7
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-11-12 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 8
    ));

    $date = DateTime::createFromFormat('Y-m-d H:i:s', '2014-11-26 19:30:00', new DateTimeZone("America/Los_Angeles"));
    $date->setTimezone(new DateTimeZone('UTC'));
    Heat::create(array(
      'status' => 'inactive',
      'season_id' => 1,
      'date' => $date,
      'delta' => 9
    ));

	}

}
