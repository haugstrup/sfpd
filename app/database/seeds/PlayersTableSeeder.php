<?php

class PlayersTableSeeder extends Seeder {

	public function run()
	{

    DB::table('players')->truncate();

    Player::create(array(
      'name' => 'Per Schwarzenberger',
      'initials' => 'PER',
      'ifpa_id' => 12220,
      'display_name' => 'Per',
    ));

    Player::create(array(
      'name' => 'Matt Henri',
      'initials' => 'FGW',
      'ifpa_id' => 16767,
      'display_name' => 'Matt H.',
    ));

    Player::create(array(
      'name' => 'Andreas Haugstrup Pedersen',
      'initials' => 'AHP',
      'ifpa_id' => 15925,
      'display_name' => 'Andreas',
    ));

    Player::create(array(
      'name' => 'Darren Ensley',
      'display_name' => 'Darren',
    ));

    Player::create(array(
      'name' => 'Brian O\'Neill',
      'initials' => 'BSO',
      'display_name' => 'Brian O.',
    ));

    Player::create(array(
      'name' => 'Vanessa Gonzalez',
      'display_name' => 'Vanessa',
    ));

    Player::create(array(
      'name' => 'Gene X Hwang',
      'initials' => 'GXH',
      'display_name' => 'Gene X',
    ));

    Player::create(array(
      'name' => 'Russ Sweetser',
      'display_name' => 'Russ',
    ));

    Player::create(array(
      'name' => 'Jeremy Williams',
      'display_name' => 'Jeremy',
    ));

    Player::create(array(
      'name' => 'Tim Harrison',
      'display_name' => 'Tim H.',
    ));

    Player::create(array(
      'name' => 'Louise Wagensonner',
      'initials' => 'LAW',
      'display_name' => 'Louise',
    ));

    Player::create(array(
      'name' => 'Eric Wagensonner',
      'display_name' => 'Eric W.',
    ));

    Player::create(array(
      'name' => 'Ron Richards',
      'display_name' => 'Ron R.',
    ));

    Player::create(array(
      'name' => 'Shon Dolcini',
      'display_name' => 'Shon',
    ));

    Player::create(array(
      'name' => 'Marti Leann Brass',
      'display_name' => 'Leann',
    ));

    Player::create(array(
      'name' => 'Kevin Montgomery',
      'display_name' => 'Kevin J.',
    ));

    Player::create(array(
      'name' => 'Allison O\'Neill',
      'display_name' => 'Allison',
    ));

    Player::create(array(
      'name' => 'Eric Raymond',
      'display_name' => 'Eric R.',
    ));

    Player::create(array(
      'name' => 'Dave Hermanas',
      'display_name' => 'Dave H.',
    ));

    Player::create(array(
      'name' => 'Andrei Massenkoff',
      'display_name' => 'Andrei',
    ));

    Player::create(array(
      'name' => 'Chris Harkins',
      'display_name' => 'Chris H.',
    ));

    Player::create(array(
      'name' => 'Josh Lehan',
      'display_name' => 'Josh',
    ));

    Player::create(array(
      'name' => 'Jon Drukman',
      'display_name' => 'Jon D.',
    ));

    Player::create(array(
      'name' => 'Maura Deveraux',
      'display_name' => 'Maura',
    ));

    Player::create(array(
      'name' => 'Rob Brunner',
      'display_name' => 'Rob B.',
    ));

    Player::create(array(
      'name' => 'Sally Sparks',
      'display_name' => 'Sally',
    ));

    Player::create(array(
      'name' => 'Jeff Fehervari',
      'display_name' => 'Jeff F-f-f-f',
    ));

    Player::create(array(
      'name' => 'Zac Wollons',
      'display_name' => 'Zac',
    ));

    Player::create(array(
      'name' => 'Flor Betancourth',
      'display_name' => 'Flor',
    ));

    Player::create(array(
      'name' => 'Anish Adalja',
      'display_name' => 'Anish',
    ));

    Player::create(array(
      'name' => 'Rob Coli',
      'display_name' => 'Rob C.',
    ));

    Player::create(array(
      'name' => 'James Squires',
      'initials' => 'JRS',
      'display_name' => 'James S.',
    ));

    Player::create(array(
      'name' => 'Jessica Rodgers',
      'display_name' => 'Jessica',
    ));

    Player::create(array(
      'name' => 'Matt Talley',
      'display_name' => 'Matt T.',
    ));

    Player::create(array(
      'name' => 'Ryan Wooley',
      'display_name' => 'Ryan',
    ));

    Player::create(array(
      'name' => 'Randy Chung',
      'display_name' => 'Randy',
    ));

    Player::create(array(
      'name' => 'Scott Bromley',
      'display_name' => 'Scott',
    ));

    Player::create(array(
      'name' => 'Anthony Rocco',
      'display_name' => 'Anthony',
    ));

    Player::create(array(
      'name' => 'Jody Wirt',
      'display_name' => 'Jody',
    ));

    Player::create(array(
      'name' => 'Helene Grotans',
      'display_name' => 'Helene',
    ));

    Player::create(array(
      'name' => 'Sammy Claiborn',
      'display_name' => 'Sammy',
    ));

    Player::create(array(
      'name' => 'Amy Jo Johnson',
      'display_name' => 'Amy Jo',
    ));

    Player::create(array(
      'name' => 'Michael Jankosky',
      'display_name' => 'Michael J.',
    ));

    Player::create(array(
      'name' => 'Lianna Lopez',
      'display_name' => 'Lianna',
    ));

    Player::create(array(
      'name' => 'Ryan Hess',
      'display_name' => 'Ryan H.',
    ));

    Player::create(array(
      'name' => 'Jay Goldlist',
      'display_name' => 'Jay G.',
    ));

    Player::create(array(
      'name' => 'Nate Robinson',
      'display_name' => 'Nate R.',
    ));

    Player::create(array(
      'name' => 'Tony Urso',
      'display_name' => 'Tony U.',
    ));

    Player::create(array(
      'name' => 'Chris Lindboe',
      'display_name' => 'Chris L.',
    ));

    Player::create(array(
      'name' => 'Ted Carstensen',
      'display_name' => 'Ted',
    ));

    Player::create(array(
      'name' => 'Erin Ray',
      'display_name' => 'Erin',
    ));

    Player::create(array(
      'name' => 'Matt Sarnoff',
      'display_name' => 'Matt S.',
    ));

    Player::create(array(
      'name' => 'Christel Macabeo',
      'display_name' => 'Christel',
    ));

    Player::create(array(
      'name' => 'Mickey Thoms',
      'display_name' => 'Mickey',
    ));

    Player::create(array(
      'name' => 'Matt Willmarth',
      'display_name' => 'Matt W.',
    ));

    Player::create(array(
      'name' => 'Andy Steinhauser',
      'display_name' => 'Andy',
    ));

    Player::create(array(
      'name' => 'Devon Kelly',
      'display_name' => 'Devon',
    ));

    Player::create(array(
      'name' => 'Jake Wrench',
      'display_name' => 'Jake',
    ));

    Player::create(array(
      'name' => 'Jessica Thompson',
      'display_name' => 'Jessica T.',
    ));

    Player::create(array(
      'name' => 'John Lautman',
      'display_name' => 'John L.',
    ));

    Player::create(array(
      'name' => 'Richard Leavitt',
      'display_name' => 'Richard L.',
    ));

    Player::create(array(
      'name' => 'Spoon Silverscoop',
      'display_name' => 'Spoon',
    ));

    Player::create(array(
      'name' => 'Tracy Chiatello',
      'display_name' => 'Tracy',
    ));

    Player::create(array(
      'name' => 'Jeff Cleary',
      'display_name' => 'Jeff C.',
    ));

    Player::create(array(
      'name' => 'Brian Smock',
      'display_name' => 'Brian S.',
    ));

    Player::create(array(
      'name' => 'Ash Aiwase',
      'display_name' => 'Ash',
    ));

    Player::create(array(
      'name' => 'Laura Lewinson',
      'display_name' => 'Laura',
    ));

    Player::create(array(
      'name' => 'Emily Guzzardi',
      'display_name' => 'Emily',
    ));

    Player::create(array(
      'name' => 'Jaime Uziel',
      'display_name' => 'Jaime',
    ));

    Player::create(array(
      'name' => 'Bob Klossner',
      'display_name' => 'Bob',
    ));

    Player::create(array(
      'name' => 'Courtney Klossner',
      'display_name' => 'Courtney',
    ));

    Player::create(array(
      'name' => 'Jason Rosenberg',
      'display_name' => 'Jason',
    ));

    Player::create(array(
      'name' => 'Eddie Codel',
      'display_name' => 'Eddie',
    ));

    Player::create(array(
      'name' => 'Joe Fernandez',
      'display_name' => 'Joe',
    ));

    Player::create(array(
      'name' => 'Jengis Alpar',
      'display_name' => 'Jengis',
    ));

    Player::create(array(
      'name' => 'Chris Gibbs',
      'display_name' => 'Chris G.',
    ));

    Player::create(array(
      'name' => 'Water Gomez',
      'display_name' => 'Walter',
    ));

    Player::create(array(
      'name' => 'Nate Weber',
      'display_name' => 'Nate W.',
    ));

	}

}
