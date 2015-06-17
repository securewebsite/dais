<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxRateToCustomerGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax_rate_to_customer_group', function(Blueprint $table)
		{
			$table->integer('tax_rate_id')->unsigned()->index('tax_rate_id_idx');
			$table->integer('customer_group_id')->unsigned()->index('customer_group_id_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tax_rate_to_customer_group');
	}

}
