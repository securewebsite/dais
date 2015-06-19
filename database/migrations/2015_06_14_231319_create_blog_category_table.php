<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_category', function(Blueprint $table)
		{
			$table->increments('category_id');
			$table->string('image');
			$table->integer('parent_id')->unsigned();
			$table->boolean('top');
			$table->integer('columns')->unsigned();
			$table->integer('sort_order')->unsigned();
			$table->boolean('status');
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
		Schema::drop('blog_category');
	}

}
