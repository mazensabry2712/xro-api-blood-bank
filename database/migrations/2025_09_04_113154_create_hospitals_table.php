<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{

    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('license_number')->unique();
            $table->enum('type', ['governmental', 'private', 'university', 'military', 'charity'])
                ->default('governmental');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('hotline')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->unsignedInteger('region_id');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('restrict');
            $table->string('email_otp')->nullable();
            $table->timestamp('email_otp_expires_at')->nullable();
            $table->string('password');
        });
    }

    public function down()
    {
        Schema::drop('hospitals');
    }
}
