<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreParking;
use App\Models\Parking;
use Sentinel;

class ParkingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.role:administrator');
    }

    public function create(StoreParking $request)
    {
        $parking = array(
            'city' => $request->get('city'),
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'spots' => $request->get('spots'),
            'working_time' => sprintf('%02d', $request->get('working_time')) . ':' . sprintf('%02d', $request->get('working_time_two')) . '-' . sprintf('%02d', $request->get('working_time_three')) . ':' . sprintf('%02d', $request->get('working_time_four')),
            'price_per_hour' => $request->get('price_per_hour') . '.' . sprintf('%02d', $request->get('price_per_hour_two')),
            'price_of_reservation' => $request->get('price_of_reservation') . '.' . sprintf('%02d', $request->get('price_of_reservation_two')),
            'price_of_reservation_penalty' => $request->get('price_of_reservation_penalty') . '.' . sprintf('%02d', $request->get('price_of_reservation_penalty_two'))
        );

        $new_parking = new Parking;
        $data = $new_parking->saveParking($parking);

        session()->flash('info', 'New parking lot created in ' . $data->city . '!');
        return redirect()->route('dashboard');
    }

    public function create_form()
    {
        return view('centaur.parking.create');
    }
}
