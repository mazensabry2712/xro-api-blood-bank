<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHerosTable extends Migration {

	public function up()
	{
		Schema::create('heros', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('name');
			$table->text('description');
		});
	}

	public function down()
	{
		Schema::drop('heros');
	}
}
