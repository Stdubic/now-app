<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
			$table->tinyIncrements('id')->unsigned();
			$table->string('app_name', 50);
			$table->boolean('https');
			$table->string('app_email', 50)->nullable();
			$table->string('smtp_host', 256)->nullable();
			$table->unsignedSmallInteger('smtp_port')->nullable();
			$table->string('smtp_protocol', 3)->nullable();
			$table->string('smtp_username', 128)->nullable();
			$table->string('smtp_password', 128)->nullable();
			$table->string('timezone', 50)->default('UTC');
			$table->string('date_format', 15);
			$table->string('time_format', 15);
			$table->string('currency_code', 3);
			$table->string('google_api_key', 50)->nullable();
			$table->unsignedTinyInteger('min_pass_len');
			$table->string('jwt_secret_key', 128);
			$table->unsignedInteger('jwt_expiration_time');
			$table->string('media_storage', 50);
			$table->string('media_visibility', 10);
			$table->unsignedInteger('max_upload_size');
			$table->unsignedSmallInteger('thumb_width_landscape');
			$table->unsignedSmallInteger('thumb_width_portrait');
			$table->string('image_filter', 500)->nullable();
			$table->string('video_filter', 500)->nullable();
			$table->boolean('registration_active');
			$table->unsignedSmallInteger('registration_role_id');
			$table->unsignedSmallInteger('registration_api_role_id');
			$table->string('aws_access_key_id', 128)->nullable();
			$table->string('aws_secret_access_key', 128)->nullable();
			$table->string('aws_default_region', 50)->nullable();
			$table->string('aws_bucket_name', 50)->nullable();
			$table->string('aws_bucket_url', 1000)->nullable();
			$table->string('onesignal_rest_api_key', 128)->nullable();
			$table->string('onesignal_user_auth_key', 128)->nullable();
			$table->string('onesignal_application_id', 128)->nullable();
            $table->integer('application_fee');
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
        Schema::dropIfExists('settings');
    }
}
