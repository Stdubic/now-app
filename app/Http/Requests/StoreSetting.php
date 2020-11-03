<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSetting extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'app_name' => 'required|string|max:50',
			'https' => 'boolean',
			'app_email' => 'nullable|email|max:50',
			'smtp_host' => 'nullable|string|max:256',
			'smtp_port' => 'nullable|integer|min:1',
			'smtp_username' => 'nullable|string|max:128',
			'smtp_password' => 'nullable|string|max:128',
			'smtp_protocol' => Rule::in(['tls', 'ssl']),
			'timezone' => 'required|timezone',
			'date_format' => 'required|string|max:15',
			'time_format' => 'required|string|max:15',
			'currency_code' => 'required|string|max:3',
			'google_api_key' => 'nullable|string|max:50',
			'min_pass_len' => 'required|integer|min:1',
			'jwt_secret_key' => 'required|string|max:128',
			'jwt_expiration_time' => 'required|integer|min:1',
			'media_storage' => 'string|max:50',
			'media_visibility' => 'string|max:10',
			'max_upload_size' => 'required|integer|min:1',
			'thumb_width_landscape' => 'required|integer|min:1',
			'thumb_width_portrait' => 'required|integer|min:1',
			'image_filter' => 'nullable|string|max:500',
			'video_filter' => 'nullable|string|max:500',
			'registration_active' => 'boolean',
			'registration_role_id' => 'required|integer|min:1',
			'registration_api_role_id' => 'required|integer|min:1',
			'aws_access_key_id' => 'nullable|string|max:128',
			'aws_secret_access_key' => 'nullable|string|max:128',
			'aws_default_region' => 'nullable|string|max:128',
			'aws_bucket_name' => 'nullable|string|max:50',
			'aws_bucket_url' => 'nullable|string|max:1000',
			'onesignal_rest_api_key' => 'nullable|string|max:128',
			'onesignal_user_auth_key' => 'nullable|string|max:128'
        ];
    }
}
