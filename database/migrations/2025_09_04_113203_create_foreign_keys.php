<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('blood_requests', function(Blueprint $table) {
			$table->foreign('blood_type_id')->references('id')->on('blood_types')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
		Schema::table('blood_requests', function(Blueprint $table) {
			$table->foreign('hospital_id')->references('id')->on('hospitals')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
		Schema::table('bloods_donor', function(Blueprint $table) {
			$table->foreign('blood_type_id')->references('id')->on('blood_types')
						->onDelete('restrict')
						->onUpdate('cascade');
		});
		Schema::table('cities', function(Blueprint $table) {
			$table->foreign('governorate_id')->references('id')->on('governorates')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('regions', function(Blueprint $table) {
			$table->foreign('city_id')->references('id')->on('cities')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('blood_requests', function(Blueprint $table) {
			$table->dropForeign('blood_requests_blood_type_id_foreign');
		});
		Schema::table('blood_requests', function(Blueprint $table) {
			$table->dropForeign('blood_requests_hospital_id_foreign');
		});
		Schema::table('bloods_donor', function(Blueprint $table) {
			$table->dropForeign('bloods_donor_blood_type_id_foreign');
		});
		Schema::table('cities', function(Blueprint $table) {
			$table->dropForeign('cities_governorate_id_foreign');
		});
		Schema::table('regions', function(Blueprint $table) {
			$table->dropForeign('regions_city_id_foreign');
		});
	}
}
