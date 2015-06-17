<?php

use Illuminate\Database\Seeder;

class TaxClassTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('tax_class')->delete();
        
		\DB::table('tax_class')->insert(array (
			0 => 
			array (
				'tax_class_id' => 9,
				'title' => 'Taxable Goods',
				'description' => 'products requiring sales tax',
				'date_added' => '2009-01-06 23:21:53',
				'date_modified' => '2015-03-25 17:54:51',
			),
			1 => 
			array (
				'tax_class_id' => 10,
				'title' => 'Downloadable Products',
				'description' => 'Downloadable',
				'date_added' => '2011-09-21 22:19:39',
				'date_modified' => '2014-06-28 00:33:19',
			),
		));
	}

}
