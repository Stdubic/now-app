<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('instance_type_id');
            $table->unsignedInteger('instance_category_id');
            $table->string('name', 50);
            $table->longText('description');
            $table->dateTime('time_start');
            $table->dateTime('time_end');
            $table->float('latitude');
            $table->float('longitude');
            $table->integer('price');
            $table->float('discount');
            $table->integer('quantity');
            $table->integer('claim_duration');
            $table->string('city', 50);
            $table->string('address', 50);
            $table->string('postcode', 50);
            $table->longText('charity_link');
            $table->boolean('active');
            $table->boolean('is_charity');
            $table->boolean('is_now');
            $table->boolean('is_bay_now');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instance');
    }
}
