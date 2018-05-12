<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityParkings extends FormRequest
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
            'start_hour' => 'numeric|min:0|max:24',
            'start_minute' => 'numeric|min:0|max:24',
            'close_hour' => 'numeric|min:0|max:24',
            'close_minute' => 'numeric|min:0|max:24',
            'price_one' => 'numeric|min:0|max:999',
            'price_two' => 'numeric|min:0|max:99',
            'reservation_one' => 'numeric|min:0|max:999',
            'reservation_two' => 'numeric|min:0|max:99',
            'penalty_one' => 'numeric|min:0|max:999',
            'penalty_two' => 'numeric|min:0|max:99'
        ];
    }
}
