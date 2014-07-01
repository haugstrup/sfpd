<?php

class UsersTableSeeder extends Seeder {

  public function run()
  {

    DB::table('users')->truncate();

    User::create(array(
      'email' => 'andreas@solitude.dk',
      'password' => Hash::make('penguin'),
    ));

    User::create(array(
      'email' => 'per@sfpins.org',
      'password' => Hash::make('swedishpenguin'),
    ));

  }

}
