<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('category')->delete();
        
		\DB::table('category')->insert(array (
			0 => 
			array (
				'category_id' => 17,
				'image' => '',
				'parent_id' => 0,
				'top' => 1,
				'columns' => 1,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-01-03 21:08:57',
				'date_modified' => '2015-06-02 23:17:09',
			),
			1 => 
			array (
				'category_id' => 18,
				'image' => 'data/demo/hp_2.jpg',
				'parent_id' => 0,
				'top' => 1,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-01-05 21:49:15',
				'date_modified' => '2015-06-02 23:10:40',
			),
			2 => 
			array (
				'category_id' => 20,
				'image' => 'data/demo/compaq_presario.jpg',
				'parent_id' => 0,
				'top' => 1,
				'columns' => 1,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-01-05 21:49:43',
				'date_modified' => '2015-06-02 23:10:21',
			),
			3 => 
			array (
				'category_id' => 24,
				'image' => '',
				'parent_id' => 0,
				'top' => 1,
				'columns' => 1,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-01-20 02:36:26',
				'date_modified' => '2015-06-02 23:17:05',
			),
			4 => 
			array (
				'category_id' => 25,
				'image' => '',
				'parent_id' => 0,
				'top' => 1,
				'columns' => 1,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-01-31 01:04:25',
				'date_modified' => '2015-06-02 23:09:38',
			),
			5 => 
			array (
				'category_id' => 26,
				'image' => '',
				'parent_id' => 20,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-01-31 01:55:14',
				'date_modified' => '2015-06-02 23:10:36',
			),
			6 => 
			array (
				'category_id' => 27,
				'image' => '',
				'parent_id' => 20,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-01-31 01:55:34',
				'date_modified' => '2015-06-02 23:10:32',
			),
			7 => 
			array (
				'category_id' => 28,
				'image' => '',
				'parent_id' => 25,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-02-02 13:11:12',
				'date_modified' => '2015-06-02 23:09:52',
			),
			8 => 
			array (
				'category_id' => 29,
				'image' => '',
				'parent_id' => 25,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-02-02 13:11:37',
				'date_modified' => '2015-06-02 23:09:43',
			),
			9 => 
			array (
				'category_id' => 30,
				'image' => '',
				'parent_id' => 25,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-02-02 13:11:59',
				'date_modified' => '2015-06-02 23:10:06',
			),
			10 => 
			array (
				'category_id' => 31,
				'image' => '',
				'parent_id' => 25,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-02-03 14:17:24',
				'date_modified' => '2015-06-02 23:10:11',
			),
			11 => 
			array (
				'category_id' => 32,
				'image' => '',
				'parent_id' => 25,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-02-03 14:17:34',
				'date_modified' => '2015-06-02 23:10:17',
			),
			12 => 
			array (
				'category_id' => 33,
				'image' => '',
				'parent_id' => 0,
				'top' => 1,
				'columns' => 1,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-02-03 14:17:55',
				'date_modified' => '2015-06-02 23:09:34',
			),
			13 => 
			array (
				'category_id' => 34,
				'image' => 'data/demo/ipod_touch_4.jpg',
				'parent_id' => 0,
				'top' => 1,
				'columns' => 3,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2009-02-03 14:18:11',
				'date_modified' => '2015-06-02 23:11:13',
			),
			14 => 
			array (
				'category_id' => 35,
				'image' => '',
				'parent_id' => 28,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-17 10:06:48',
				'date_modified' => '2015-06-02 23:09:56',
			),
			15 => 
			array (
				'category_id' => 36,
				'image' => '',
				'parent_id' => 28,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-17 10:07:13',
				'date_modified' => '2015-06-02 23:10:00',
			),
			16 => 
			array (
				'category_id' => 37,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-18 14:03:39',
				'date_modified' => '2015-06-02 23:16:39',
			),
			17 => 
			array (
				'category_id' => 38,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-18 14:03:51',
				'date_modified' => '2015-06-02 23:16:36',
			),
			18 => 
			array (
				'category_id' => 39,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-18 14:04:17',
				'date_modified' => '2015-06-02 23:16:43',
			),
			19 => 
			array (
				'category_id' => 40,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-18 14:05:36',
				'date_modified' => '2015-06-02 23:16:46',
			),
			20 => 
			array (
				'category_id' => 41,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-18 14:05:49',
				'date_modified' => '2015-06-02 23:16:51',
			),
			21 => 
			array (
				'category_id' => 42,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-18 14:06:34',
				'date_modified' => '2015-06-02 23:16:55',
			),
			22 => 
			array (
				'category_id' => 43,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-18 14:06:49',
				'date_modified' => '2015-06-02 23:11:25',
			),
			23 => 
			array (
				'category_id' => 44,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-21 15:39:21',
				'date_modified' => '2015-06-02 23:11:29',
			),
			24 => 
			array (
				'category_id' => 45,
				'image' => '',
				'parent_id' => 18,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-24 18:29:16',
				'date_modified' => '2015-06-02 23:10:50',
			),
			25 => 
			array (
				'category_id' => 46,
				'image' => '',
				'parent_id' => 18,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-09-24 18:29:31',
				'date_modified' => '2015-06-02 23:10:45',
			),
			26 => 
			array (
				'category_id' => 47,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-07 11:13:16',
				'date_modified' => '2015-06-02 23:11:34',
			),
			27 => 
			array (
				'category_id' => 48,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-07 11:13:33',
				'date_modified' => '2015-06-02 23:12:27',
			),
			28 => 
			array (
				'category_id' => 49,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-07 11:14:04',
				'date_modified' => '2015-06-02 23:12:31',
			),
			29 => 
			array (
				'category_id' => 50,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-07 11:14:23',
				'date_modified' => '2015-06-02 23:15:46',
			),
			30 => 
			array (
				'category_id' => 51,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-07 11:14:38',
				'date_modified' => '2015-06-02 23:15:50',
			),
			31 => 
			array (
				'category_id' => 52,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-07 11:16:09',
				'date_modified' => '2015-06-02 23:15:55',
			),
			32 => 
			array (
				'category_id' => 53,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-07 11:28:53',
				'date_modified' => '2015-06-02 23:16:11',
			),
			33 => 
			array (
				'category_id' => 54,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-07 11:29:16',
				'date_modified' => '2015-06-02 23:16:15',
			),
			34 => 
			array (
				'category_id' => 55,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-08 10:31:32',
				'date_modified' => '2015-06-02 23:16:20',
			),
			35 => 
			array (
				'category_id' => 56,
				'image' => '',
				'parent_id' => 34,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2010-11-08 10:31:50',
				'date_modified' => '2015-06-02 23:16:25',
			),
			36 => 
			array (
				'category_id' => 57,
				'image' => '',
				'parent_id' => 0,
				'top' => 1,
				'columns' => 1,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2011-04-26 08:53:16',
				'date_modified' => '2015-06-02 23:17:13',
			),
			37 => 
			array (
				'category_id' => 58,
				'image' => '',
				'parent_id' => 52,
				'top' => 0,
				'columns' => 0,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2011-05-08 13:44:16',
				'date_modified' => '2015-06-02 23:16:00',
			),
			38 => 
			array (
				'category_id' => 59,
				'image' => '',
				'parent_id' => 0,
				'top' => 0,
				'columns' => 1,
				'sort_order' => 0,
				'status' => 1,
				'date_added' => '2015-04-22 13:21:30',
				'date_modified' => '2015-06-02 23:10:55',
			),
		));
	}

}
