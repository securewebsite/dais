<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_post_image', function(Blueprint $table)
		{
			$table->increments('post_image_id');
			$table->integer('post_id')->unsigned();
			$table->string('image')->nullable();
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
		Schema::drop('blog_post_image');
	}

}
