<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$this->call('UsersTableSeeder');
		$this->command->info('Users table seeded.');

		$this->call('PlayersTableSeeder');
		$this->command->info('Players table seeded.');

		$this->call('SeasonsTableSeeder');
		$this->command->info('Seasons table seeded.');

		$this->call('MachinesTableSeeder');
		$this->command->info('Machines table seeded.');

		$this->call('HeatsTableSeeder');
		$this->command->info('Heats table seeded.');

		$this->call('GroupsTableSeeder');
		$this->command->info('Groups table seeded.');

		$this->call('GamesTableSeeder');
		$this->command->info('Games table seeded.');

		$this->call('ResultsTableSeeder');
		$this->command->info('Results table seeded.');

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

}
