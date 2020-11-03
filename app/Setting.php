<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App
 */
class Setting extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
		'app_name',
		'https',
		'app_email',
		'smtp_host',
		'smtp_port',
		'smtp_username',
		'smtp_password',
		'smtp_protocol',
		'timezone',
		'date_format',
		'time_format',
		'currency_code',
		'google_api_key',
		'min_pass_len',
		'jwt_secret_key',
		'jwt_expiration_time',
		'media_storage',
		'media_visibility',
		'max_upload_size',
		'thumb_width_landscape',
		'thumb_width_portrait',
		'image_filter',
		'video_filter',
		'registration_active',
		'registration_role_id',
		'registration_api_role_id',
		'aws_access_key_id',
		'aws_secret_access_key',
		'aws_default_region',
		'aws_bucket_name',
		'aws_bucket_url',
		'onesignal_rest_api_key',
		'onesignal_user_auth_key',
		'onesignal_application_id',
		'stripe_rest_api_key',
		'stripe_client_id',
		'stripe_publishable_key',
		'application_fee',
		'currency',
    ];
}
