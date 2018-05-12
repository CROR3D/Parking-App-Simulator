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
            'image' => 'images/parking/' . $request->get('image'),
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

    public function update_view()
    {
        if(isset($_POST['select'])) {

            $slug = $_POST['select'];

            if($slug) {

                $parking = Parking::where('slug', $slug)->first();

                return redirect()->route('update_fill', ['slug' => $slug]);

            }

        } elseif(isset($_POST['select_all'])) {

            $city = $_POST['select_all'];

            if($city) {

                $parking = Parking::where('city', $city)->get();

                $city = strtolower($city);

                return redirect()->route('update_city', ['$city' => $city]);
            }
        }

        session()->flash('info', 'Please select parking lot or city you want to update.');

        return redirect()->route('update');

    }

    public function update_city($city)
    {
        return view('centaur.parking.update_city')->with('city', $city);
    }

    public function update_city_form(StoreCityParkings $request, $city)
    {
        $parking_list = Parking::where('city', $city)->get();

        $operation = [
            'add_time' => isset($_POST['add_time']),
            'subtract_time' => isset($_POST['subtract_time']),
            'add_price' => isset($_POST['add_price']),
            'add_reservation' => isset($_POST['add_reservation']),
            'add_penalty' => isset($_POST['add_penalty'])
        ];

        $form = [
            'start_hour' => $request->get('start_hour'),
            'start_minute' => $request->get('start_minute'),
            'close_hour' => $request->get('close_hour'),
            'close_minute' => $request->get('close_minute'),
            'price_one' => $request->get('price_one'),
            'price_two' => $request->get('price_two'),
            'reservation_one' => $request->get('reservation_one'),
            'reservation_two' => $request->get('reservation_two'),
            'penalty_one' => $request->get('penalty_one'),
            'penalty_two' => $request->get('penalty_two')
        ];

        if($form['start_hour']) {
            if($operation['add_time']) {

            } elseif($operation['subtract_time']) {

            } else {

            }

        } elseif($form['start_close']) {

            if($operation['add_time']) {

            } elseif($operation['subtract_time']) {

            } else {

            }

        } else {

        }

        foreach ($parking_list as $parking) {

            $parking->updateParking([
                'working_time' => '08:00-16:00',
                'price_per_hour' => '2.00'
            ]);

            $parking->save();
        }

        session()->flash('info', 'Parking lots in ' . $city . ' are updated!');
        return redirect()->route('dashboard');
    }

    public function update_parking($slug)
    {
        $parking = Parking::where('slug', $slug)->first();

        $first_split = explode('-', $parking->working_time);
        $second_split = explode(':', $first_split[0]);
        $third_split = explode(':', $first_split[1]);

        $working_time = [
            'one' => $second_split[0],
            'two' => $second_split[1],
            'three' => $third_split[0],
            'four' => $third_split[1]
        ];

        $fourth_split = explode('.', $parking->price_per_hour);

        $price_per_hour = [
            'one' => $fourth_split[0],
            'two' => $fourth_split[1]
        ];

        $fifth_split = explode('.', $parking->price_of_reservation);

        $price_of_reservation = [
            'one' => $fifth_split[0],
            'two' => $fifth_split[1]
        ];

        $sixth_split = explode('.', $parking->price_of_reservation_penalty);

        $price_of_reservation_penalty = [
            'one' => $sixth_split[0],
            'two' => $sixth_split[1]
        ];

        $path = explode('images/parking/', $parking->image);

        return view('centaur.parking.update')->with([
            'parking' => $parking,
            'working_time' => $working_time,
            'price_per_hour' => $price_per_hour,
            'price_of_reservation' => $price_of_reservation,
            'price_of_reservation_penalty' => $price_of_reservation_penalty,
            'path' => $path
        ]);
    }

    public function update_form(StoreParking $request, $slug)
    {
        $parking = Parking::where('slug', $slug)->first();

        $parking_data = array(
            'city' => $request->get('city'),
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'spots' => $request->get('spots'),
            'image' => 'images/parking/' . $request->get('image'),
            'working_time' => sprintf('%02d', $request->get('working_time')) . ':' . sprintf('%02d', $request->get('working_time_two')) . '-' . sprintf('%02d', $request->get('working_time_three')) . ':' . sprintf('%02d', $request->get('working_time_four')),
            'price_per_hour' => $request->get('price_per_hour') . '.' . sprintf('%02d', $request->get('price_per_hour_two')),
            'price_of_reservation' => $request->get('price_of_reservation') . '.' . sprintf('%02d', $request->get('price_of_reservation_two')),
            'price_of_reservation_penalty' => $request->get('price_of_reservation_penalty') . '.' . sprintf('%02d', $request->get('price_of_reservation_penalty_two'))
        );


        $parking->updateParking($parking_data);

        session()->flash('info', 'Parking lot in ' . $parking->city . '(' . $parking->name . ') is updated!');
        return redirect()->route('dashboard');
    }
}
