<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_clients', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 256);
            $table->string('address', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->bigInteger('post_code')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('active')->default(true);
            $table->string('contact_number', 50)->nullable();
            $table->string('timezone', 50)->default('UTC');
            $table->unsignedSmallInteger('role_id');
            $table->integer('category');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('stripe_account', 100)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('app_clients');
    }
}
