<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateBloodsDonorTable extends Migration {

	public function up()
	{
		Schema::create('bloods_donor', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('blood_type_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('bloods_donor');
	}
}
