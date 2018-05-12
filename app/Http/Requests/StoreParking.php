<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParking extends FormRequest
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
            'city' => 'required',
            'name' => 'required',
            'address' => 'required',
            'spots' => 'required|numeric',
            'image' => 'required',
            'working_time' => 'required|numeric|min:0|max:24',
            'working_time_two' => 'required|numeric|min:0|max:60',
            'working_time_three' => 'required|numeric|min:0|max:24',
            'working_time_four' => 'required|numeric|min:0|max:60',
            'price_per_hour' => 'required|numeric',
            'price_per_hour_two' => 'required|numeric',
            'price_of_reservation' => 'required|numeric',
            'price_of_reservation_two' => 'required|numeric',
            'price_of_reservation_penalty' => 'required|numeric',
            'price_of_reservation_penalty_two' => 'required|numeric'
        ];
    }
}
