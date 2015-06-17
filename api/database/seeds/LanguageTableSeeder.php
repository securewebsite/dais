<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('language')->delete();
        
		\DB::table('language')->insert(array (
			0 => 
			array (
				'language_id' => 1,
				'name' => 'English',
				'code' => 'en',
				'locale' => 'en_US.UTF-8,en_US,en-gb,english',
				'image' => 'gb.png',
				'directory' => 'english',
				'filename' => 'english',
				'sort_order' => 1,
				'status' => 1,
			),
		));
	}

}
