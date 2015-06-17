<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxRateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax_rate', function(Blueprint $table)
		{
			$table->increments('tax_rate_id');
			$table->integer('geo_zone_id')->unsigned();
			$table->string('name', 32);
			$table->decimal('rate', 15, 4)->unsigned()->default(0.0000);
			$table->char('type', 1);
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
			$table->dateTime('date_modified')->default('0000-00-00 00:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tax_rate');
	}

}
