<?php

use Illuminate\Database\Seeder;

class ProductRewardTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_reward')->delete();
        
		\DB::table('product_reward')->insert(array (
			0 => 
			array (
				'product_reward_id' => 750,
				'product_id' => 42,
				'customer_group_id' => 1,
				'points' => 100,
			),
			1 => 
			array (
				'product_reward_id' => 751,
				'product_id' => 42,
				'customer_group_id' => 2,
				'points' => 0,
			),
			2 => 
			array (
				'product_reward_id' => 752,
				'product_id' => 42,
				'customer_group_id' => 3,
				'points' => 0,
			),
			3 => 
			array (
				'product_reward_id' => 753,
				'product_id' => 42,
				'customer_group_id' => 4,
				'points' => 0,
			),
			4 => 
			array (
				'product_reward_id' => 754,
				'product_id' => 30,
				'customer_group_id' => 1,
				'points' => 200,
			),
			5 => 
			array (
				'product_reward_id' => 755,
				'product_id' => 30,
				'customer_group_id' => 2,
				'points' => 0,
			),
			6 => 
			array (
				'product_reward_id' => 756,
				'product_id' => 30,
				'customer_group_id' => 3,
				'points' => 0,
			),
			7 => 
			array (
				'product_reward_id' => 757,
				'product_id' => 30,
				'customer_group_id' => 4,
				'points' => 0,
			),
			8 => 
			array (
				'product_reward_id' => 758,
				'product_id' => 50,
				'customer_group_id' => 1,
				'points' => 0,
			),
			9 => 
			array (
				'product_reward_id' => 759,
				'product_id' => 50,
				'customer_group_id' => 2,
				'points' => 0,
			),
			10 => 
			array (
				'product_reward_id' => 760,
				'product_id' => 50,
				'customer_group_id' => 3,
				'points' => 0,
			),
			11 => 
			array (
				'product_reward_id' => 761,
				'product_id' => 50,
				'customer_group_id' => 4,
				'points' => 0,
			),
			12 => 
			array (
				'product_reward_id' => 762,
				'product_id' => 47,
				'customer_group_id' => 1,
				'points' => 300,
			),
			13 => 
			array (
				'product_reward_id' => 763,
				'product_id' => 47,
				'customer_group_id' => 2,
				'points' => 0,
			),
			14 => 
			array (
				'product_reward_id' => 764,
				'product_id' => 47,
				'customer_group_id' => 3,
				'points' => 0,
			),
			15 => 
			array (
				'product_reward_id' => 765,
				'product_id' => 47,
				'customer_group_id' => 4,
				'points' => 0,
			),
			16 => 
			array (
				'product_reward_id' => 766,
				'product_id' => 28,
				'customer_group_id' => 1,
				'points' => 400,
			),
			17 => 
			array (
				'product_reward_id' => 767,
				'product_id' => 28,
				'customer_group_id' => 2,
				'points' => 0,
			),
			18 => 
			array (
				'product_reward_id' => 768,
				'product_id' => 28,
				'customer_group_id' => 3,
				'points' => 0,
			),
			19 => 
			array (
				'product_reward_id' => 769,
				'product_id' => 28,
				'customer_group_id' => 4,
				'points' => 0,
			),
			20 => 
			array (
				'product_reward_id' => 770,
				'product_id' => 41,
				'customer_group_id' => 1,
				'points' => 0,
			),
			21 => 
			array (
				'product_reward_id' => 771,
				'product_id' => 41,
				'customer_group_id' => 2,
				'points' => 0,
			),
			22 => 
			array (
				'product_reward_id' => 772,
				'product_id' => 41,
				'customer_group_id' => 3,
				'points' => 0,
			),
			23 => 
			array (
				'product_reward_id' => 773,
				'product_id' => 41,
				'customer_group_id' => 4,
				'points' => 0,
			),
			24 => 
			array (
				'product_reward_id' => 774,
				'product_id' => 40,
				'customer_group_id' => 1,
				'points' => 0,
			),
			25 => 
			array (
				'product_reward_id' => 775,
				'product_id' => 40,
				'customer_group_id' => 2,
				'points' => 0,
			),
			26 => 
			array (
				'product_reward_id' => 776,
				'product_id' => 40,
				'customer_group_id' => 3,
				'points' => 0,
			),
			27 => 
			array (
				'product_reward_id' => 777,
				'product_id' => 40,
				'customer_group_id' => 4,
				'points' => 0,
			),
			28 => 
			array (
				'product_reward_id' => 778,
				'product_id' => 48,
				'customer_group_id' => 1,
				'points' => 0,
			),
			29 => 
			array (
				'product_reward_id' => 779,
				'product_id' => 48,
				'customer_group_id' => 2,
				'points' => 0,
			),
			30 => 
			array (
				'product_reward_id' => 780,
				'product_id' => 48,
				'customer_group_id' => 3,
				'points' => 0,
			),
			31 => 
			array (
				'product_reward_id' => 781,
				'product_id' => 48,
				'customer_group_id' => 4,
				'points' => 0,
			),
			32 => 
			array (
				'product_reward_id' => 782,
				'product_id' => 36,
				'customer_group_id' => 1,
				'points' => 0,
			),
			33 => 
			array (
				'product_reward_id' => 783,
				'product_id' => 36,
				'customer_group_id' => 2,
				'points' => 0,
			),
			34 => 
			array (
				'product_reward_id' => 784,
				'product_id' => 36,
				'customer_group_id' => 3,
				'points' => 0,
			),
			35 => 
			array (
				'product_reward_id' => 785,
				'product_id' => 36,
				'customer_group_id' => 4,
				'points' => 0,
			),
			36 => 
			array (
				'product_reward_id' => 786,
				'product_id' => 34,
				'customer_group_id' => 1,
				'points' => 0,
			),
			37 => 
			array (
				'product_reward_id' => 787,
				'product_id' => 34,
				'customer_group_id' => 2,
				'points' => 0,
			),
			38 => 
			array (
				'product_reward_id' => 788,
				'product_id' => 34,
				'customer_group_id' => 3,
				'points' => 0,
			),
			39 => 
			array (
				'product_reward_id' => 789,
				'product_id' => 34,
				'customer_group_id' => 4,
				'points' => 0,
			),
			40 => 
			array (
				'product_reward_id' => 790,
				'product_id' => 32,
				'customer_group_id' => 1,
				'points' => 0,
			),
			41 => 
			array (
				'product_reward_id' => 791,
				'product_id' => 32,
				'customer_group_id' => 2,
				'points' => 0,
			),
			42 => 
			array (
				'product_reward_id' => 792,
				'product_id' => 32,
				'customer_group_id' => 3,
				'points' => 0,
			),
			43 => 
			array (
				'product_reward_id' => 793,
				'product_id' => 32,
				'customer_group_id' => 4,
				'points' => 0,
			),
			44 => 
			array (
				'product_reward_id' => 794,
				'product_id' => 43,
				'customer_group_id' => 1,
				'points' => 600,
			),
			45 => 
			array (
				'product_reward_id' => 795,
				'product_id' => 43,
				'customer_group_id' => 2,
				'points' => 0,
			),
			46 => 
			array (
				'product_reward_id' => 796,
				'product_id' => 43,
				'customer_group_id' => 3,
				'points' => 0,
			),
			47 => 
			array (
				'product_reward_id' => 797,
				'product_id' => 43,
				'customer_group_id' => 4,
				'points' => 0,
			),
			48 => 
			array (
				'product_reward_id' => 798,
				'product_id' => 44,
				'customer_group_id' => 1,
				'points' => 700,
			),
			49 => 
			array (
				'product_reward_id' => 799,
				'product_id' => 44,
				'customer_group_id' => 2,
				'points' => 0,
			),
			50 => 
			array (
				'product_reward_id' => 800,
				'product_id' => 44,
				'customer_group_id' => 3,
				'points' => 0,
			),
			51 => 
			array (
				'product_reward_id' => 801,
				'product_id' => 44,
				'customer_group_id' => 4,
				'points' => 0,
			),
			52 => 
			array (
				'product_reward_id' => 802,
				'product_id' => 45,
				'customer_group_id' => 1,
				'points' => 800,
			),
			53 => 
			array (
				'product_reward_id' => 803,
				'product_id' => 45,
				'customer_group_id' => 2,
				'points' => 0,
			),
			54 => 
			array (
				'product_reward_id' => 804,
				'product_id' => 45,
				'customer_group_id' => 3,
				'points' => 0,
			),
			55 => 
			array (
				'product_reward_id' => 805,
				'product_id' => 45,
				'customer_group_id' => 4,
				'points' => 0,
			),
			56 => 
			array (
				'product_reward_id' => 806,
				'product_id' => 31,
				'customer_group_id' => 1,
				'points' => 0,
			),
			57 => 
			array (
				'product_reward_id' => 807,
				'product_id' => 31,
				'customer_group_id' => 2,
				'points' => 0,
			),
			58 => 
			array (
				'product_reward_id' => 808,
				'product_id' => 31,
				'customer_group_id' => 3,
				'points' => 0,
			),
			59 => 
			array (
				'product_reward_id' => 809,
				'product_id' => 31,
				'customer_group_id' => 4,
				'points' => 0,
			),
			60 => 
			array (
				'product_reward_id' => 810,
				'product_id' => 29,
				'customer_group_id' => 1,
				'points' => 0,
			),
			61 => 
			array (
				'product_reward_id' => 811,
				'product_id' => 29,
				'customer_group_id' => 2,
				'points' => 0,
			),
			62 => 
			array (
				'product_reward_id' => 812,
				'product_id' => 29,
				'customer_group_id' => 3,
				'points' => 0,
			),
			63 => 
			array (
				'product_reward_id' => 813,
				'product_id' => 29,
				'customer_group_id' => 4,
				'points' => 0,
			),
			64 => 
			array (
				'product_reward_id' => 814,
				'product_id' => 49,
				'customer_group_id' => 1,
				'points' => 1000,
			),
			65 => 
			array (
				'product_reward_id' => 815,
				'product_id' => 49,
				'customer_group_id' => 2,
				'points' => 0,
			),
			66 => 
			array (
				'product_reward_id' => 816,
				'product_id' => 49,
				'customer_group_id' => 3,
				'points' => 0,
			),
			67 => 
			array (
				'product_reward_id' => 817,
				'product_id' => 49,
				'customer_group_id' => 4,
				'points' => 0,
			),
			68 => 
			array (
				'product_reward_id' => 818,
				'product_id' => 33,
				'customer_group_id' => 1,
				'points' => 0,
			),
			69 => 
			array (
				'product_reward_id' => 819,
				'product_id' => 33,
				'customer_group_id' => 2,
				'points' => 0,
			),
			70 => 
			array (
				'product_reward_id' => 820,
				'product_id' => 33,
				'customer_group_id' => 3,
				'points' => 0,
			),
			71 => 
			array (
				'product_reward_id' => 821,
				'product_id' => 33,
				'customer_group_id' => 4,
				'points' => 0,
			),
			72 => 
			array (
				'product_reward_id' => 822,
				'product_id' => 46,
				'customer_group_id' => 1,
				'points' => 0,
			),
			73 => 
			array (
				'product_reward_id' => 823,
				'product_id' => 46,
				'customer_group_id' => 2,
				'points' => 0,
			),
			74 => 
			array (
				'product_reward_id' => 824,
				'product_id' => 46,
				'customer_group_id' => 3,
				'points' => 0,
			),
			75 => 
			array (
				'product_reward_id' => 825,
				'product_id' => 46,
				'customer_group_id' => 4,
				'points' => 0,
			),
		));
	}

}
