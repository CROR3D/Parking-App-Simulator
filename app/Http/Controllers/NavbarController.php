<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;

class NavbarController extends Controller
{
    public function select()
    {
        $city_list = Parking::select('city')->distinct()->orderBy('city', 'ASC')->get();
        $parking_list = Parking::all();
        $city_values = [];
        $parking_values = [];
        $count = 0;

        foreach($city_list as $city) {
            $city_values[$city->city] = $count++;
        }

        foreach ($parking_list as $parking) {
            $parking_values[$parking->name] = $city_values[$parking->city];
        }

        return view('centaur.parking.view')->with([
            'city_list' => $city_list,
            'parking_list' => $parking_list,
            'city_values' => $city_values,
            'parking_values' => $parking_values
        ]);
    }

    public function index() {
        return view('index');
    }
}
