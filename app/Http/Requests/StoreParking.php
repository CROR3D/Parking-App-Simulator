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
            'working_time' => 'required',
            'price_per_hour' => 'required|numeric',
            'price_of_reservation' => 'required|numeric',
            'price_of_reservation_penalty' => 'required|numeric'
        ];
    }
}
