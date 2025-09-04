<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlsTable extends Migration {

	public function up()
	{
		Schema::create('urls', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('name');
			$table->text('url');
			$table->string('icon')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('urls');
	}
}
