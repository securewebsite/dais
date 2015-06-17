<?php

use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('tag')->delete();
        
		\DB::table('tag')->insert(array (
			0 => 
			array (
				'tag_id' => 49,
				'section' => 'page',
				'element_id' => 10,
				'language_id' => 1,
				'tag' => '',
			),
			1 => 
			array (
				'tag_id' => 52,
				'section' => 'product_category',
				'element_id' => 0,
				'language_id' => 1,
				'tag' => 'lorem',
			),
			2 => 
			array (
				'tag_id' => 53,
				'section' => 'product_category',
				'element_id' => 0,
				'language_id' => 1,
				'tag' => 'ipsum',
			),
			3 => 
			array (
				'tag_id' => 54,
				'section' => 'product_category',
				'element_id' => 0,
				'language_id' => 1,
				'tag' => 'lorem',
			),
			4 => 
			array (
				'tag_id' => 55,
				'section' => 'product_category',
				'element_id' => 0,
				'language_id' => 1,
				'tag' => 'ipsum',
			),
			5 => 
			array (
				'tag_id' => 104,
				'section' => 'product_category',
				'element_id' => 33,
				'language_id' => 1,
				'tag' => '',
			),
			6 => 
			array (
				'tag_id' => 105,
				'section' => 'product_category',
				'element_id' => 25,
				'language_id' => 1,
				'tag' => '',
			),
			7 => 
			array (
				'tag_id' => 106,
				'section' => 'product_category',
				'element_id' => 29,
				'language_id' => 1,
				'tag' => '',
			),
			8 => 
			array (
				'tag_id' => 107,
				'section' => 'product_category',
				'element_id' => 28,
				'language_id' => 1,
				'tag' => '',
			),
			9 => 
			array (
				'tag_id' => 108,
				'section' => 'product_category',
				'element_id' => 35,
				'language_id' => 1,
				'tag' => '',
			),
			10 => 
			array (
				'tag_id' => 109,
				'section' => 'product_category',
				'element_id' => 36,
				'language_id' => 1,
				'tag' => '',
			),
			11 => 
			array (
				'tag_id' => 110,
				'section' => 'product_category',
				'element_id' => 30,
				'language_id' => 1,
				'tag' => '',
			),
			12 => 
			array (
				'tag_id' => 111,
				'section' => 'product_category',
				'element_id' => 31,
				'language_id' => 1,
				'tag' => '',
			),
			13 => 
			array (
				'tag_id' => 112,
				'section' => 'product_category',
				'element_id' => 32,
				'language_id' => 1,
				'tag' => '',
			),
			14 => 
			array (
				'tag_id' => 113,
				'section' => 'product_category',
				'element_id' => 20,
				'language_id' => 1,
				'tag' => '',
			),
			15 => 
			array (
				'tag_id' => 114,
				'section' => 'product_category',
				'element_id' => 27,
				'language_id' => 1,
				'tag' => '',
			),
			16 => 
			array (
				'tag_id' => 115,
				'section' => 'product_category',
				'element_id' => 26,
				'language_id' => 1,
				'tag' => '',
			),
			17 => 
			array (
				'tag_id' => 116,
				'section' => 'product_category',
				'element_id' => 18,
				'language_id' => 1,
				'tag' => 'laptops',
			),
			18 => 
			array (
				'tag_id' => 117,
				'section' => 'product_category',
				'element_id' => 18,
				'language_id' => 1,
				'tag' => 'notebooks',
			),
			19 => 
			array (
				'tag_id' => 118,
				'section' => 'product_category',
				'element_id' => 18,
				'language_id' => 1,
				'tag' => 'windows',
			),
			20 => 
			array (
				'tag_id' => 119,
				'section' => 'product_category',
				'element_id' => 18,
				'language_id' => 1,
				'tag' => 'mac',
			),
			21 => 
			array (
				'tag_id' => 120,
				'section' => 'product_category',
				'element_id' => 18,
				'language_id' => 1,
				'tag' => 'apple',
			),
			22 => 
			array (
				'tag_id' => 121,
				'section' => 'product_category',
				'element_id' => 46,
				'language_id' => 1,
				'tag' => 'mac',
			),
			23 => 
			array (
				'tag_id' => 122,
				'section' => 'product_category',
				'element_id' => 46,
				'language_id' => 1,
				'tag' => 'imac',
			),
			24 => 
			array (
				'tag_id' => 123,
				'section' => 'product_category',
				'element_id' => 46,
				'language_id' => 1,
				'tag' => 'macbook',
			),
			25 => 
			array (
				'tag_id' => 124,
				'section' => 'product_category',
				'element_id' => 46,
				'language_id' => 1,
				'tag' => 'macbook pro',
			),
			26 => 
			array (
				'tag_id' => 125,
				'section' => 'product_category',
				'element_id' => 46,
				'language_id' => 1,
				'tag' => 'macbook air',
			),
			27 => 
			array (
				'tag_id' => 126,
				'section' => 'product_category',
				'element_id' => 45,
				'language_id' => 1,
				'tag' => '',
			),
			28 => 
			array (
				'tag_id' => 127,
				'section' => 'product_category',
				'element_id' => 59,
				'language_id' => 1,
				'tag' => 'lorem',
			),
			29 => 
			array (
				'tag_id' => 128,
				'section' => 'product_category',
				'element_id' => 59,
				'language_id' => 1,
				'tag' => 'ipsum',
			),
			30 => 
			array (
				'tag_id' => 130,
				'section' => 'product_category',
				'element_id' => 34,
				'language_id' => 1,
				'tag' => '',
			),
			31 => 
			array (
				'tag_id' => 131,
				'section' => 'product_category',
				'element_id' => 43,
				'language_id' => 1,
				'tag' => '',
			),
			32 => 
			array (
				'tag_id' => 132,
				'section' => 'product_category',
				'element_id' => 44,
				'language_id' => 1,
				'tag' => '',
			),
			33 => 
			array (
				'tag_id' => 133,
				'section' => 'product_category',
				'element_id' => 47,
				'language_id' => 1,
				'tag' => '',
			),
			34 => 
			array (
				'tag_id' => 134,
				'section' => 'product_category',
				'element_id' => 48,
				'language_id' => 1,
				'tag' => '',
			),
			35 => 
			array (
				'tag_id' => 135,
				'section' => 'product_category',
				'element_id' => 49,
				'language_id' => 1,
				'tag' => '',
			),
			36 => 
			array (
				'tag_id' => 136,
				'section' => 'product_category',
				'element_id' => 50,
				'language_id' => 1,
				'tag' => '',
			),
			37 => 
			array (
				'tag_id' => 137,
				'section' => 'product_category',
				'element_id' => 51,
				'language_id' => 1,
				'tag' => '',
			),
			38 => 
			array (
				'tag_id' => 138,
				'section' => 'product_category',
				'element_id' => 52,
				'language_id' => 1,
				'tag' => '',
			),
			39 => 
			array (
				'tag_id' => 139,
				'section' => 'product_category',
				'element_id' => 58,
				'language_id' => 1,
				'tag' => '',
			),
			40 => 
			array (
				'tag_id' => 141,
				'section' => 'product_category',
				'element_id' => 53,
				'language_id' => 1,
				'tag' => '',
			),
			41 => 
			array (
				'tag_id' => 142,
				'section' => 'product_category',
				'element_id' => 54,
				'language_id' => 1,
				'tag' => '',
			),
			42 => 
			array (
				'tag_id' => 143,
				'section' => 'product_category',
				'element_id' => 55,
				'language_id' => 1,
				'tag' => '',
			),
			43 => 
			array (
				'tag_id' => 144,
				'section' => 'product_category',
				'element_id' => 56,
				'language_id' => 1,
				'tag' => '',
			),
			44 => 
			array (
				'tag_id' => 145,
				'section' => 'product_category',
				'element_id' => 38,
				'language_id' => 1,
				'tag' => '',
			),
			45 => 
			array (
				'tag_id' => 146,
				'section' => 'product_category',
				'element_id' => 37,
				'language_id' => 1,
				'tag' => '',
			),
			46 => 
			array (
				'tag_id' => 147,
				'section' => 'product_category',
				'element_id' => 39,
				'language_id' => 1,
				'tag' => '',
			),
			47 => 
			array (
				'tag_id' => 148,
				'section' => 'product_category',
				'element_id' => 40,
				'language_id' => 1,
				'tag' => '',
			),
			48 => 
			array (
				'tag_id' => 149,
				'section' => 'product_category',
				'element_id' => 41,
				'language_id' => 1,
				'tag' => '',
			),
			49 => 
			array (
				'tag_id' => 150,
				'section' => 'product_category',
				'element_id' => 42,
				'language_id' => 1,
				'tag' => '',
			),
			50 => 
			array (
				'tag_id' => 152,
				'section' => 'product_category',
				'element_id' => 24,
				'language_id' => 1,
				'tag' => '',
			),
			51 => 
			array (
				'tag_id' => 153,
				'section' => 'product_category',
				'element_id' => 17,
				'language_id' => 1,
				'tag' => '',
			),
			52 => 
			array (
				'tag_id' => 154,
				'section' => 'product_category',
				'element_id' => 57,
				'language_id' => 1,
				'tag' => '',
			),
			53 => 
			array (
				'tag_id' => 184,
				'section' => 'product',
				'element_id' => 42,
				'language_id' => 1,
				'tag' => '',
			),
			54 => 
			array (
				'tag_id' => 185,
				'section' => 'product',
				'element_id' => 30,
				'language_id' => 1,
				'tag' => '',
			),
			55 => 
			array (
				'tag_id' => 186,
				'section' => 'product',
				'element_id' => 50,
				'language_id' => 1,
				'tag' => 'dais',
			),
			56 => 
			array (
				'tag_id' => 187,
				'section' => 'product',
				'element_id' => 50,
				'language_id' => 1,
				'tag' => 'live',
			),
			57 => 
			array (
				'tag_id' => 188,
				'section' => 'product',
				'element_id' => 50,
				'language_id' => 1,
				'tag' => '2015',
			),
			58 => 
			array (
				'tag_id' => 189,
				'section' => 'product',
				'element_id' => 50,
				'language_id' => 1,
				'tag' => 'dais live 2015',
			),
			59 => 
			array (
				'tag_id' => 190,
				'section' => 'product',
				'element_id' => 47,
				'language_id' => 1,
				'tag' => '',
			),
			60 => 
			array (
				'tag_id' => 191,
				'section' => 'product',
				'element_id' => 28,
				'language_id' => 1,
				'tag' => '',
			),
			61 => 
			array (
				'tag_id' => 192,
				'section' => 'product',
				'element_id' => 41,
				'language_id' => 1,
				'tag' => '',
			),
			62 => 
			array (
				'tag_id' => 193,
				'section' => 'product',
				'element_id' => 40,
				'language_id' => 1,
				'tag' => '',
			),
			63 => 
			array (
				'tag_id' => 194,
				'section' => 'product',
				'element_id' => 48,
				'language_id' => 1,
				'tag' => '',
			),
			64 => 
			array (
				'tag_id' => 195,
				'section' => 'product',
				'element_id' => 36,
				'language_id' => 1,
				'tag' => '',
			),
			65 => 
			array (
				'tag_id' => 196,
				'section' => 'product',
				'element_id' => 34,
				'language_id' => 1,
				'tag' => '',
			),
			66 => 
			array (
				'tag_id' => 197,
				'section' => 'product',
				'element_id' => 32,
				'language_id' => 1,
				'tag' => '',
			),
			67 => 
			array (
				'tag_id' => 198,
				'section' => 'product',
				'element_id' => 43,
				'language_id' => 1,
				'tag' => 'mac',
			),
			68 => 
			array (
				'tag_id' => 199,
				'section' => 'product',
				'element_id' => 43,
				'language_id' => 1,
				'tag' => 'macbook',
			),
			69 => 
			array (
				'tag_id' => 200,
				'section' => 'product',
				'element_id' => 44,
				'language_id' => 1,
				'tag' => 'mac',
			),
			70 => 
			array (
				'tag_id' => 201,
				'section' => 'product',
				'element_id' => 44,
				'language_id' => 1,
				'tag' => 'macbook',
			),
			71 => 
			array (
				'tag_id' => 202,
				'section' => 'product',
				'element_id' => 44,
				'language_id' => 1,
				'tag' => 'macbook air',
			),
			72 => 
			array (
				'tag_id' => 203,
				'section' => 'product',
				'element_id' => 45,
				'language_id' => 1,
				'tag' => 'mac',
			),
			73 => 
			array (
				'tag_id' => 204,
				'section' => 'product',
				'element_id' => 45,
				'language_id' => 1,
				'tag' => 'macbook',
			),
			74 => 
			array (
				'tag_id' => 205,
				'section' => 'product',
				'element_id' => 45,
				'language_id' => 1,
				'tag' => 'macbook pro',
			),
			75 => 
			array (
				'tag_id' => 206,
				'section' => 'product',
				'element_id' => 31,
				'language_id' => 1,
				'tag' => '',
			),
			76 => 
			array (
				'tag_id' => 207,
				'section' => 'product',
				'element_id' => 29,
				'language_id' => 1,
				'tag' => '',
			),
			77 => 
			array (
				'tag_id' => 208,
				'section' => 'product',
				'element_id' => 49,
				'language_id' => 1,
				'tag' => '',
			),
			78 => 
			array (
				'tag_id' => 209,
				'section' => 'product',
				'element_id' => 33,
				'language_id' => 1,
				'tag' => '',
			),
			79 => 
			array (
				'tag_id' => 210,
				'section' => 'product',
				'element_id' => 46,
				'language_id' => 1,
				'tag' => '',
			),
			80 => 
			array (
				'tag_id' => 211,
				'section' => 'page',
				'element_id' => 4,
				'language_id' => 1,
				'tag' => 'about us',
			),
			81 => 
			array (
				'tag_id' => 212,
				'section' => 'page',
				'element_id' => 4,
				'language_id' => 1,
				'tag' => 'lorem',
			),
			82 => 
			array (
				'tag_id' => 213,
				'section' => 'page',
				'element_id' => 4,
				'language_id' => 1,
				'tag' => 'ipsum',
			),
			83 => 
			array (
				'tag_id' => 214,
				'section' => 'page',
				'element_id' => 8,
				'language_id' => 1,
				'tag' => '',
			),
			84 => 
			array (
				'tag_id' => 215,
				'section' => 'page',
				'element_id' => 6,
				'language_id' => 1,
				'tag' => '',
			),
			85 => 
			array (
				'tag_id' => 216,
				'section' => 'page',
				'element_id' => 11,
				'language_id' => 1,
				'tag' => 'online',
			),
			86 => 
			array (
				'tag_id' => 217,
				'section' => 'page',
				'element_id' => 11,
				'language_id' => 1,
				'tag' => 'webinar',
			),
			87 => 
			array (
				'tag_id' => 218,
				'section' => 'page',
				'element_id' => 3,
				'language_id' => 1,
				'tag' => '',
			),
			88 => 
			array (
				'tag_id' => 219,
				'section' => 'page',
				'element_id' => 7,
				'language_id' => 1,
				'tag' => '',
			),
			89 => 
			array (
				'tag_id' => 220,
				'section' => 'page',
				'element_id' => 5,
				'language_id' => 1,
				'tag' => '',
			),
			90 => 
			array (
				'tag_id' => 221,
				'section' => 'blog_category',
				'element_id' => 1,
				'language_id' => 1,
				'tag' => 'general',
			),
			91 => 
			array (
				'tag_id' => 222,
				'section' => 'blog_category',
				'element_id' => 2,
				'language_id' => 1,
				'tag' => 'lorem',
			),
			92 => 
			array (
				'tag_id' => 223,
				'section' => 'blog_category',
				'element_id' => 2,
				'language_id' => 1,
				'tag' => 'ipsum',
			),
			93 => 
			array (
				'tag_id' => 224,
				'section' => 'blog_category',
				'element_id' => 2,
				'language_id' => 1,
				'tag' => 'latest product news',
			),
			94 => 
			array (
				'tag_id' => 225,
				'section' => 'post',
				'element_id' => 1,
				'language_id' => 1,
				'tag' => 'lorem',
			),
			95 => 
			array (
				'tag_id' => 226,
				'section' => 'post',
				'element_id' => 1,
				'language_id' => 1,
				'tag' => 'ipsum',
			),
		));
	}

}
