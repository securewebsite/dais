<?php

use Illuminate\Database\Seeder;

class ProductImageTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_image')->delete();
        
		\DB::table('product_image')->insert(array (
			0 => 
			array (
				'product_image_id' => 2760,
				'product_id' => 42,
				'image' => 'data/demo/canon_eos_5d_1.jpg',
				'sort_order' => 0,
			),
			1 => 
			array (
				'product_image_id' => 2761,
				'product_id' => 42,
				'image' => 'data/demo/canon_eos_5d_2.jpg',
				'sort_order' => 0,
			),
			2 => 
			array (
				'product_image_id' => 2762,
				'product_id' => 42,
				'image' => 'data/demo/canon_logo.jpg',
				'sort_order' => 0,
			),
			3 => 
			array (
				'product_image_id' => 2763,
				'product_id' => 42,
				'image' => 'data/demo/compaq_presario.jpg',
				'sort_order' => 0,
			),
			4 => 
			array (
				'product_image_id' => 2764,
				'product_id' => 42,
				'image' => 'data/demo/hp_1.jpg',
				'sort_order' => 0,
			),
			5 => 
			array (
				'product_image_id' => 2765,
				'product_id' => 30,
				'image' => 'data/demo/canon_eos_5d_2.jpg',
				'sort_order' => 0,
			),
			6 => 
			array (
				'product_image_id' => 2766,
				'product_id' => 30,
				'image' => 'data/demo/canon_eos_5d_3.jpg',
				'sort_order' => 0,
			),
			7 => 
			array (
				'product_image_id' => 2767,
				'product_id' => 47,
				'image' => 'data/demo/hp_2.jpg',
				'sort_order' => 0,
			),
			8 => 
			array (
				'product_image_id' => 2768,
				'product_id' => 47,
				'image' => 'data/demo/hp_3.jpg',
				'sort_order' => 0,
			),
			9 => 
			array (
				'product_image_id' => 2769,
				'product_id' => 28,
				'image' => 'data/demo/htc_touch_hd_2.jpg',
				'sort_order' => 0,
			),
			10 => 
			array (
				'product_image_id' => 2770,
				'product_id' => 28,
				'image' => 'data/demo/htc_touch_hd_3.jpg',
				'sort_order' => 0,
			),
			11 => 
			array (
				'product_image_id' => 2771,
				'product_id' => 41,
				'image' => 'data/demo/imac_2.jpg',
				'sort_order' => 0,
			),
			12 => 
			array (
				'product_image_id' => 2772,
				'product_id' => 41,
				'image' => 'data/demo/imac_3.jpg',
				'sort_order' => 0,
			),
			13 => 
			array (
				'product_image_id' => 2773,
				'product_id' => 40,
				'image' => 'data/demo/iphone_2.jpg',
				'sort_order' => 0,
			),
			14 => 
			array (
				'product_image_id' => 2774,
				'product_id' => 40,
				'image' => 'data/demo/iphone_3.jpg',
				'sort_order' => 0,
			),
			15 => 
			array (
				'product_image_id' => 2775,
				'product_id' => 40,
				'image' => 'data/demo/iphone_4.jpg',
				'sort_order' => 0,
			),
			16 => 
			array (
				'product_image_id' => 2776,
				'product_id' => 40,
				'image' => 'data/demo/iphone_5.jpg',
				'sort_order' => 0,
			),
			17 => 
			array (
				'product_image_id' => 2777,
				'product_id' => 40,
				'image' => 'data/demo/iphone_6.jpg',
				'sort_order' => 0,
			),
			18 => 
			array (
				'product_image_id' => 2778,
				'product_id' => 48,
				'image' => 'data/demo/ipod_classic_2.jpg',
				'sort_order' => 0,
			),
			19 => 
			array (
				'product_image_id' => 2779,
				'product_id' => 48,
				'image' => 'data/demo/ipod_classic_3.jpg',
				'sort_order' => 0,
			),
			20 => 
			array (
				'product_image_id' => 2780,
				'product_id' => 48,
				'image' => 'data/demo/ipod_classic_4.jpg',
				'sort_order' => 0,
			),
			21 => 
			array (
				'product_image_id' => 2781,
				'product_id' => 36,
				'image' => 'data/demo/ipod_nano_2.jpg',
				'sort_order' => 0,
			),
			22 => 
			array (
				'product_image_id' => 2782,
				'product_id' => 36,
				'image' => 'data/demo/ipod_nano_3.jpg',
				'sort_order' => 0,
			),
			23 => 
			array (
				'product_image_id' => 2783,
				'product_id' => 36,
				'image' => 'data/demo/ipod_nano_4.jpg',
				'sort_order' => 0,
			),
			24 => 
			array (
				'product_image_id' => 2784,
				'product_id' => 36,
				'image' => 'data/demo/ipod_nano_5.jpg',
				'sort_order' => 0,
			),
			25 => 
			array (
				'product_image_id' => 2785,
				'product_id' => 34,
				'image' => 'data/demo/ipod_shuffle_2.jpg',
				'sort_order' => 0,
			),
			26 => 
			array (
				'product_image_id' => 2786,
				'product_id' => 34,
				'image' => 'data/demo/ipod_shuffle_3.jpg',
				'sort_order' => 0,
			),
			27 => 
			array (
				'product_image_id' => 2787,
				'product_id' => 34,
				'image' => 'data/demo/ipod_shuffle_4.jpg',
				'sort_order' => 0,
			),
			28 => 
			array (
				'product_image_id' => 2788,
				'product_id' => 34,
				'image' => 'data/demo/ipod_shuffle_5.jpg',
				'sort_order' => 0,
			),
			29 => 
			array (
				'product_image_id' => 2789,
				'product_id' => 32,
				'image' => 'data/demo/ipod_touch_2.jpg',
				'sort_order' => 0,
			),
			30 => 
			array (
				'product_image_id' => 2790,
				'product_id' => 32,
				'image' => 'data/demo/ipod_touch_3.jpg',
				'sort_order' => 0,
			),
			31 => 
			array (
				'product_image_id' => 2791,
				'product_id' => 32,
				'image' => 'data/demo/ipod_touch_4.jpg',
				'sort_order' => 0,
			),
			32 => 
			array (
				'product_image_id' => 2792,
				'product_id' => 32,
				'image' => 'data/demo/ipod_touch_5.jpg',
				'sort_order' => 0,
			),
			33 => 
			array (
				'product_image_id' => 2793,
				'product_id' => 32,
				'image' => 'data/demo/ipod_touch_6.jpg',
				'sort_order' => 0,
			),
			34 => 
			array (
				'product_image_id' => 2794,
				'product_id' => 32,
				'image' => 'data/demo/ipod_touch_7.jpg',
				'sort_order' => 0,
			),
			35 => 
			array (
				'product_image_id' => 2795,
				'product_id' => 43,
				'image' => 'data/demo/macbook_2.jpg',
				'sort_order' => 0,
			),
			36 => 
			array (
				'product_image_id' => 2796,
				'product_id' => 43,
				'image' => 'data/demo/macbook_3.jpg',
				'sort_order' => 0,
			),
			37 => 
			array (
				'product_image_id' => 2797,
				'product_id' => 43,
				'image' => 'data/demo/macbook_4.jpg',
				'sort_order' => 0,
			),
			38 => 
			array (
				'product_image_id' => 2798,
				'product_id' => 43,
				'image' => 'data/demo/macbook_5.jpg',
				'sort_order' => 0,
			),
			39 => 
			array (
				'product_image_id' => 2799,
				'product_id' => 44,
				'image' => 'data/demo/macbook_air_2.jpg',
				'sort_order' => 0,
			),
			40 => 
			array (
				'product_image_id' => 2800,
				'product_id' => 44,
				'image' => 'data/demo/macbook_air_3.jpg',
				'sort_order' => 0,
			),
			41 => 
			array (
				'product_image_id' => 2801,
				'product_id' => 44,
				'image' => 'data/demo/macbook_air_4.jpg',
				'sort_order' => 0,
			),
			42 => 
			array (
				'product_image_id' => 2802,
				'product_id' => 45,
				'image' => 'data/demo/macbook_pro_2.jpg',
				'sort_order' => 0,
			),
			43 => 
			array (
				'product_image_id' => 2803,
				'product_id' => 45,
				'image' => 'data/demo/macbook_pro_3.jpg',
				'sort_order' => 0,
			),
			44 => 
			array (
				'product_image_id' => 2804,
				'product_id' => 45,
				'image' => 'data/demo/macbook_pro_4.jpg',
				'sort_order' => 0,
			),
			45 => 
			array (
				'product_image_id' => 2805,
				'product_id' => 31,
				'image' => 'data/demo/nikon_d300_2.jpg',
				'sort_order' => 0,
			),
			46 => 
			array (
				'product_image_id' => 2806,
				'product_id' => 31,
				'image' => 'data/demo/nikon_d300_3.jpg',
				'sort_order' => 0,
			),
			47 => 
			array (
				'product_image_id' => 2807,
				'product_id' => 31,
				'image' => 'data/demo/nikon_d300_4.jpg',
				'sort_order' => 0,
			),
			48 => 
			array (
				'product_image_id' => 2808,
				'product_id' => 31,
				'image' => 'data/demo/nikon_d300_5.jpg',
				'sort_order' => 0,
			),
			49 => 
			array (
				'product_image_id' => 2809,
				'product_id' => 29,
				'image' => 'data/demo/palm_treo_pro_2.jpg',
				'sort_order' => 0,
			),
			50 => 
			array (
				'product_image_id' => 2810,
				'product_id' => 29,
				'image' => 'data/demo/palm_treo_pro_3.jpg',
				'sort_order' => 0,
			),
			51 => 
			array (
				'product_image_id' => 2811,
				'product_id' => 49,
				'image' => 'data/demo/samsung_tab_2.jpg',
				'sort_order' => 0,
			),
			52 => 
			array (
				'product_image_id' => 2812,
				'product_id' => 49,
				'image' => 'data/demo/samsung_tab_3.jpg',
				'sort_order' => 0,
			),
			53 => 
			array (
				'product_image_id' => 2813,
				'product_id' => 49,
				'image' => 'data/demo/samsung_tab_4.jpg',
				'sort_order' => 0,
			),
			54 => 
			array (
				'product_image_id' => 2814,
				'product_id' => 49,
				'image' => 'data/demo/samsung_tab_5.jpg',
				'sort_order' => 0,
			),
			55 => 
			array (
				'product_image_id' => 2815,
				'product_id' => 49,
				'image' => 'data/demo/samsung_tab_6.jpg',
				'sort_order' => 0,
			),
			56 => 
			array (
				'product_image_id' => 2816,
				'product_id' => 49,
				'image' => 'data/demo/samsung_tab_7.jpg',
				'sort_order' => 0,
			),
			57 => 
			array (
				'product_image_id' => 2817,
				'product_id' => 46,
				'image' => 'data/demo/sony_vaio_2.jpg',
				'sort_order' => 0,
			),
			58 => 
			array (
				'product_image_id' => 2818,
				'product_id' => 46,
				'image' => 'data/demo/sony_vaio_3.jpg',
				'sort_order' => 0,
			),
			59 => 
			array (
				'product_image_id' => 2819,
				'product_id' => 46,
				'image' => 'data/demo/sony_vaio_4.jpg',
				'sort_order' => 0,
			),
			60 => 
			array (
				'product_image_id' => 2820,
				'product_id' => 46,
				'image' => 'data/demo/sony_vaio_5.jpg',
				'sort_order' => 0,
			),
		));
	}

}
