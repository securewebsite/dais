<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address', function(Blueprint $table)
		{
			$table->increments('address_id');
			$table->integer('customer_id')->unsigned()->index('customer_id_idx');
			$table->string('firstname', 32);
			$table->string('lastname', 32);
			$table->string('company', 32);
			$table->string('company_id', 32);
			$table->string('tax_id', 32);
			$table->string('address_1', 128);
			$table->string('address_2', 128);
			$table->string('city', 128);
			$table->string('postcode', 10);
			$table->integer('country_id')->unsigned();
			$table->integer('zone_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('address');
	}

}
