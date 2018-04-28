<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreParking;
use App\Models\Parking;
use Sentinel;

class ParkingsController extends Controller
{
    public function create(StoreParking $request)
    {
        $parking = array(
            'city' => $request->get('city'),
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'spots' => $request->get('spots'),
            'working_time' => $request->get('working_time'),
            'price_per_hour' => $request->get('price_per_hour'),
            'price_of_reservation' => $request->get('price_of_reservation'),
            'price_of_reservation_penalty' => $request->get('price_of_reservation_penalty')
        );

        $new_parking = new Parking;
        $data = $new_parking->saveParking($parking);

        session()->flash('info', 'New parking lot created in ' . $data->city . '!');
        return redirect()->route('index');
    }

    public function create_form()
    {
        return view('centaur.parking.create');
    }
}
