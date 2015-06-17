<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_post', function(Blueprint $table)
		{
			$table->increments('post_id');
			$table->string('image')->nullable();
			$table->integer('author_id')->unsigned();
			$table->date('date_available');
			$table->integer('sort_order')->unsigned();
			$table->boolean('status');
			$table->boolean('visibility')->default(1);
			$table->dateTime('date_added')->default('0000-00-00 00:00:00');
			$table->dateTime('date_modified')->default('0000-00-00 00:00:00');
			$table->integer('viewed')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_post');
	}

}
