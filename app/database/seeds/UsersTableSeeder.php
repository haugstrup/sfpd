<?php

class UsersTableSeeder extends Seeder {

  public function run()
  {

    DB::table('users')->truncate();

    User::create(array(
      'email' => 'andreas@solitude.dk',
      'password' => Hash::make($_ENV['PW_A']),
    ));

    User::create(array(
      'email' => 'per@sfpins.org',
      'password' => Hash::make($_ENV['PW_P']),
    ));

    User::create(array(
      'email' => 'echaschneider@gmail.com',
      'password' => Hash::make($_ENV['PW_E']),
    ));

  }

}
