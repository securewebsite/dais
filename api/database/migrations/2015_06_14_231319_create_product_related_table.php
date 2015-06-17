<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductRelatedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_related', function(Blueprint $table)
		{
			$table->integer('product_id')->unsigned()->index('product_id_idx');
			$table->integer('related_id')->unsigned()->index('related_id_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_related');
	}

}
