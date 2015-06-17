<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductSpecialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_special', function(Blueprint $table)
		{
			$table->increments('product_special_id');
			$table->integer('product_id')->unsigned()->index('product_id_idx');
			$table->integer('customer_group_id')->unsigned();
			$table->integer('priority')->unsigned()->default(1);
			$table->decimal('price', 15, 4)->unsigned()->default(0.0000);
			$table->date('date_start')->default('0000-00-00');
			$table->date('date_end')->default('0000-00-00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_special');
	}

}
