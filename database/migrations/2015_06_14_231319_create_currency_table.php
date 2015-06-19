<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrencyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currency', function(Blueprint $table)
		{
			$table->increments('currency_id');
			$table->string('title', 32);
			$table->string('code', 3);
			$table->string('symbol_left', 12);
			$table->string('symbol_right', 12);
			$table->char('decimal_place', 1);
			$table->float('value', 15, 8)->unsigned();
			$table->boolean('status');
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
		Schema::drop('currency');
	}

}
