<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insert([
        	[
	            'name' => 'BMW Admin',
	        	'email' => 'bmwshorties@gmail.com',
	        	'password' => bcrypt('admin#BMW2017'),
	        	'role' => 'admin'
        	],
        	[
	            'name' => 'Rudi',
	        	'email' => 'rudi@digitalsymphony.it',
	        	'password' => bcrypt('rudirudi'),
	        	'role' => 'admin'
        	],
        	[
	            'name' => 'Nandita Solomon',
	        	'email' => 'nansolo@gmail.com',
	        	'password' => bcrypt('judge+NAN7'),
	        	'role' => 'judge'
        	],
        	[
	            'name' => 'Ho Yuhang',
	        	'email' => 'hoyuhang@gmail.com',
	        	'password' => bcrypt('judge!HO2'),
	        	'role' => 'judge'
        	],
        	[
	            'name' => 'Redza Minhat',
	        	'email' => 'redzaminhat@gmail.com',
	        	'password' => bcrypt('judge@RED5'),
	        	'role' => 'judge'
        	],
        	[
	            'name' => 'Nadira Ilana',
	        	'email' => 'nad.ilana@gmail.com',
	        	'password' => bcrypt('judge#NAD6'),
	        	'role' => 'judge'
        	],
        	[
	            'name' => 'Tan Chui Mui',
	        	'email' => 'tanchuimui@gmail.com',
	        	'password' => bcrypt('judge$TAN3'),
	        	'role' => 'judge'
        	],
        ]);
    }
}

/*bmwshorties@gmail.com - admin#BMW2017
Nandita Solomon - nansolo@gmail.com - judge+NAN7
Ho Yuhang - hoyuhang@gmail.com - judge!HO2
Redza Minhat - redzaminhat@gmail.com - judge@RED5
Nadira Ilana - nad.ilana@gmail.com - judge#NAD6
Tan Chui Mui - tanchuimui@gmail.com - judge$TAN3*/