<?php

use Illuminate\Database\Seeder;

class StockStatusTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('stock_status')->delete();
        
		\DB::table('stock_status')->insert(array (
			0 => 
			array (
				'stock_status_id' => 5,
				'language_id' => 1,
				'name' => 'Out Of Stock',
			),
			1 => 
			array (
				'stock_status_id' => 6,
				'language_id' => 1,
				'name' => '2 - 3 Days',
			),
			2 => 
			array (
				'stock_status_id' => 7,
				'language_id' => 1,
				'name' => 'In Stock',
			),
			3 => 
			array (
				'stock_status_id' => 8,
				'language_id' => 1,
				'name' => 'Pre-Order',
			),
		));
	}

}
