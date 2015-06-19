<?php

use Illuminate\Database\Seeder;

class GiftCardThemeDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('gift_card_theme_description')->delete();
        
		\DB::table('gift_card_theme_description')->insert(array (
			0 => 
			array (
				'gift_card_theme_id' => 7,
				'language_id' => 1,
				'name' => 'Happy Birthday',
			),
			1 => 
			array (
				'gift_card_theme_id' => 8,
				'language_id' => 1,
				'name' => 'Gift Card',
			),
		));
	}

}
