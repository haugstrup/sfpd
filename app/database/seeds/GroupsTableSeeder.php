<?php

class GroupsTableSeeder extends Seeder {

	public function run()
	{

    DB::table('groups')->truncate();

    $hashids = new Hashids\Hashids('GN2FnrnthVuX', 9, 'abcdefghijkmnpqrstuvwxyz');

    Group::create(array(
      'code' => $hashids->encrypt(1),
      'heat_id' => 1,
      'delta' => 0
    ));

    Group::create(array(
      'code' => $hashids->encrypt(2),
      'heat_id' => 1,
      'delta' => 1
    ));

    Group::create(array(
      'code' => $hashids->encrypt(3),
      'heat_id' => 1,
      'delta' => 2
    ));

	}

}
