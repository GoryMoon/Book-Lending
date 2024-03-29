<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksAuthorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('author_book', function(Blueprint $table)
		{
			$table->integer('author_id')->unsigned();
			$table->foreign('author_id')->references('id')->on('authors')->onUpdate('cascade')->onDelete('cascade');
			$table->integer('book_id')->unsigned();
			$table->foreign('book_id')->references('id')->on('books')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('author_book');
	}

}
