<?php

class MachinesTableSeeder extends Seeder {

	public function run()
	{

    DB::table('machines')->truncate();

    Machine::create(array(
      'name' => 'Black Pyramid',
      'status' => 'active',
      'shortname' => 'BP',
    ));

    Machine::create(array(
      'name' => 'Attack From Mars',
      'status' => 'active',
      'shortname' => 'AFM',
    ));

    Machine::create(array(
      'name' => 'White Water',
      'status' => 'active',
      'shortname' => 'WH2O',
    ));

    Machine::create(array(
      'name' => 'Pinbot',
      'status' => 'active',
      'shortname' => 'PB',
    ));

    Machine::create(array(
      'name' => 'Dirty Harry',
      'status' => 'active',
      'shortname' => 'DH',
    ));

    Machine::create(array(
      'name' => 'Addams Family',
      'status' => 'active',
      'shortname' => 'TAF',
    ));

    Machine::create(array(
      'name' => 'Rocky and Bullwinkle',
      'status' => 'active',
      'shortname' => 'RB',
    ));

    Machine::create(array(
      'name' => 'Black Jack',
      'status' => 'active',
      'shortname' => 'BJ',
    ));

    Machine::create(array(
      'name' => 'Black Knight 2000',
      'status' => 'active',
      'shortname' => 'BK2',
    ));

    Machine::create(array(
      'name' => 'Captain Fantastic',
      'status' => 'active',
      'shortname' => 'CF',
    ));

    Machine::create(array(
      'name' => 'Centaur',
      'status' => 'active',
      'shortname' => 'CT',
    ));

    Machine::create(array(
      'name' => 'Checkpoint',
      'status' => 'active',
      'shortname' => 'CP',
    ));

    Machine::create(array(
      'name' => 'Cyclone',
      'status' => 'active',
      'shortname' => 'CYC',
    ));

    Machine::create(array(
      'name' => 'Demolition Man',
      'status' => 'active',
      'shortname' => 'DM',
    ));

    Machine::create(array(
      'name' => 'Embryon',
      'status' => 'active',
      'shortname' => '',
    ));

    Machine::create(array(
      'name' => 'Firepower',
      'status' => 'active',
      'shortname' => 'FP',
    ));

    Machine::create(array(
      'name' => 'Jurassic Park',
      'status' => 'active',
      'shortname' => 'JP',
    ));

    Machine::create(array(
      'name' => 'Bride of Pinbot',
      'status' => 'inactive',
      'shortname' => 'BOPB',
    ));

    Machine::create(array(
      'name' => 'Medieval Madness',
      'status' => 'active',
      'shortname' => 'MM',
    ));

    Machine::create(array(
      'name' => 'Old Chicago',
      'status' => 'active',
      'shortname' => 'OC',
    ));

    Machine::create(array(
      'name' => 'Playboy',
      'status' => 'active',
      'shortname' => 'PLBO',
    ));

    Machine::create(array(
      'name' => 'Police Force',
      'status' => 'active',
      'shortname' => 'PoFo',
    ));

    Machine::create(array(
      'name' => 'Road Show',
      'status' => 'active',
      'shortname' => 'RS',
    ));

    Machine::create(array(
      'name' => 'RollerCoaster Tycoon',
      'status' => 'active',
      'shortname' => 'RCT',
    ));

    Machine::create(array(
      'name' => 'Rollergames',
      'status' => 'active',
      'shortname' => 'RG',
    ));

    Machine::create(array(
      'name' => 'Star Trek',
      'status' => 'active',
      'shortname' => 'ST',
    ));

    Machine::create(array(
      'name' => 'Star Wars Episode 1',
      'status' => 'active',
      'shortname' => 'SW1',
    ));

    Machine::create(array(
      'name' => 'Super Mario Bros. Mushroom World',
      'status' => 'inactive',
      'shortname' => '',
    ));

    Machine::create(array(
      'name' => 'Terminator 3',
      'status' => 'active',
      'shortname' => 'T3',
    ));

    Machine::create(array(
      'name' => 'WHO Dunnit',
      'status' => 'active',
      'shortname' => 'WHO',
    ));

    Machine::create(array(
      'name' => 'Whirlwind',
      'status' => 'active',
      'shortname' => 'WW',
    ));

    Machine::create(array(
      'name' => 'Wizard of Oz',
      'status' => 'active',
      'shortname' => 'WOZ',
    ));

    Machine::create(array(
      'name' => 'X-Men',
      'status' => 'active',
      'shortname' => 'XM',
    ));

    Machine::create(array(
      'name' => 'Paragon',
      'status' => 'inactive',
      'shortname' => 'PG',
    ));

    Machine::create(array(
      'name' => 'Congo',
      'status' => 'active',
      'shortname' => 'CON',
    ));

    Machine::create(array(
      'name' => 'NBA Fastbreak',
      'status' => 'inactive',
      'shortname' => 'NBA',
    ));

	}

}
