<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateBloodRequestsTable extends Migration {

	public function up()
	{
		Schema::create('blood_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('blood_type_id')->unsigned();
			$table->bigInteger('number_bags')->default('1');
			$table->integer('hospital_id')->unsigned();
			$table->string('longitude');
			$table->string('latitude');
			$table->enum('status', array('urgent', 'medium', 'low'))->nullable();
		});
	}

	public function down()
	{
		Schema::drop('blood_requests');
	}
}
