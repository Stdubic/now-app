<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAppClient extends FormRequest
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
            'name' => 'required|max:50',
            'email' => 'required|email|unique:app_clients|max:50',
            'password' => 'required|string|min:'.setting('min_pass_len'),
            'address' => 'required|max:50',
            'post_code' => 'required|max:16',
            'contact_number' => 'required|max:16',
            'category' => 'required',
            'city' => 'required|max:50',
        ];
    }
}
