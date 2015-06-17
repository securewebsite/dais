<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_group', function(Blueprint $table)
		{
			$table->increments('customer_group_id');
			$table->integer('approval')->unsigned();
			$table->integer('company_id_display')->unsigned();
			$table->integer('company_id_required')->unsigned();
			$table->integer('tax_id_display')->unsigned();
			$table->integer('tax_id_required')->unsigned();
			$table->integer('sort_order')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_group');
	}

}
