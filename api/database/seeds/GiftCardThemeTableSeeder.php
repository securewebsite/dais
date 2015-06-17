<?php

use Illuminate\Database\Seeder;

class GiftCardThemeTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('gift_card_theme')->delete();
        
		\DB::table('gift_card_theme')->insert(array (
			0 => 
			array (
				'gift_card_theme_id' => 7,
				'image' => 'data/giftcard/gift-card-birthday.jpg',
			),
			1 => 
			array (
				'gift_card_theme_id' => 8,
				'image' => 'data/giftcard/gift-card-general.jpg',
			),
		));
	}

}
