<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->text('description');
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->text('welcome_message')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
