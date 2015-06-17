<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogCommentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_comment', function(Blueprint $table)
		{
			$table->increments('comment_id');
			$table->integer('post_id')->unsigned()->index('post_id_idx');
			$table->integer('customer_id')->unsigned();
			$table->string('author', 64)->default('');
			$table->string('email', 96);
			$table->string('website', 96);
			$table->text('text', 65535);
			$table->integer('rating')->unsigned();
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
		Schema::drop('blog_comment');
	}

}
