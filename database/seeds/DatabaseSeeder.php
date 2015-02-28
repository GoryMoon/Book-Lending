<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');
		$this->command->info('User table seeded!');
	}

}

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create([
            'username' => 'GuJa2010',
            'email' => 'gurreja@gmail.com',
            'password' => '$2y$10$tbEfJnD6B01XHfh66MrhL.COb5tggJbtkU0qpC/eEeCw4rwqpAnqm',
            'userLvl' => 0
		]);
	}

}
