<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogCategoryToLayoutTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_category_to_layout', function(Blueprint $table)
		{
			$table->integer('category_id')->unsigned()->primary();
			$table->integer('store_id')->unsigned()->index('store_id_idx');
			$table->integer('layout_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_category_to_layout');
	}

}
