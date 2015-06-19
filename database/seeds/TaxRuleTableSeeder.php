<?php

use Illuminate\Database\Seeder;

class TaxRuleTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('tax_rule')->delete();
        
		\DB::table('tax_rule')->insert(array (
			0 => 
			array (
				'tax_rule_id' => 130,
				'tax_class_id' => 9,
				'tax_rate_id' => 88,
				'based' => 'shipping',
				'priority' => 1,
			),
		));
	}

}
