<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstance extends FormRequest
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
            'city' => 'required|max:50',
            'address' => 'required|max:50',
            'postcode' => 'required|max:50',
            'instance_type_id' => 'required',
            'instance_category_id' => 'required',
            'description' => 'required|max:1000',
            'time_start' => 'required',
            'time_end' => 'required',
            'latitude' => 'required|min:5',
            'longitude' => 'required|min:5',
            'image' => 'required',
            'claim_duration' => 'required',
            'is_buy_now' => 'required',
        ];
    }
}
