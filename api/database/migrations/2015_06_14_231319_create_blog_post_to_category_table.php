<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostToCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_post_to_category', function(Blueprint $table)
		{
			$table->integer('post_id')->unsigned()->index('post_id_idx');
			$table->integer('category_id')->unsigned()->index('category_id_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_post_to_category');
	}

}
