<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 256);
            $table->boolean('active')->default(true);
            $table->string('contact_number', 50);
            $table->string('timezone', 50)->default('UTC');
            $table->unsignedSmallInteger('role_id');
            $table->json('favorite_category_ids');
            $table->string('facebook_id', 256);
            $table->string('google_id', 256);
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
        Schema::dropIfExists('app_users');
    }
}
