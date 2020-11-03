<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChartData extends FormRequest
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
			'min_date' => 'required|date',
			'max_date' => 'required|date',
			'date_format' => 'required|string|max:7'
        ];
    }
}
