<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use App\Models\Ticket;
use App\Models\Reservation;
use Carbon\Carbon;
use Sentinel;

class SelectController extends Controller
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
            $parking_values[$parking->slug] = $city_values[$parking->city];
        }

        if (Sentinel::check()) {
            return view('centaur.parking.view')->with([
                'city_list' => $city_list,
                'parking_list' => $parking_list,
                'city_values' => $city_values,
                'parking_values' => $parking_values
            ]);
        } else {
            return view('simulator.select')->with([
                'city_list' => $city_list,
                'parking_list' => $parking_list,
                'city_values' => $city_values,
                'parking_values' => $parking_values
            ]);
        }
    }

    public function index()
    {
            return view('index');
    }

    public function get_parking()
    {
        $slug = $_POST['select'];

        if($slug) {

            $parking = Parking::where('slug', $slug)->first();

            if (Sentinel::check()) {
                return redirect()->route('parking_view', ['slug' => $slug]);
            } else {
                return redirect()->route('parking_select', ['slug' => $slug]);
            }

        } else {

            session()->flash('info', 'Please select parking lot you want to enter.');

            return redirect()->route('simulator');

        }
    }

    public function view_parking($slug)
    {
        $parking = Parking::where('slug', $slug)->first();
        $taken = Ticket::where('parking_id', $parking->id)->count();
        $reserved = Reservation::where('parking_id', $parking->id)->count();

        $count = [
            'taken' => $taken,
            'reserved' => $reserved
        ];

        $status = [
            'entrance' => 1,
            'paid' => false,
            'exit' => false,
            'value' => null
        ];

        $ticket = [
            'price' => 0,
            'refund' => 0
        ];

        $ticket_check = null;
        $exit_ticket_check = null;

        $has_reservation = false;

        $reservation = [
            'code' => null,
            'expire' => null
        ];

        if (Sentinel::check()) {
            $user_id = Sentinel::getUser()->id;

            if($res = Reservation::where('user_id', $user_id)->first()) {
                $reservation['code'] = $res->code;
                $reservation['expire'] = $res->expire_time;

                $has_reservation = true;
            }
        }

        if(session('got_ticket') === 1) {
            $status['entrance'] = 2;
        }

        if(session('value')) {
            $status['value'] = session('value');
        }

        if(session('got_ticket') === 2) {
            $status['entrance'] = 3;
        }

        if(session('got_ticket') === 3) {
            $status['entrance'] = 4;
        }

        if(session('got_ticket') === 4) {
            $status['entrance'] = 5;
        }

        if(session('got_ticket') === 5) {
            $status['entrance'] = 5;
            $exit_ticket_check = session('exit_ticket_check');
            $status['exit'] = true;
        }

        if(session('got_ticket') === 3 && session('price')) {
            $status['entrance'] = 4;
            $ticket['price'] = session('price');
            $ticket_check = session('ticket_check');
        }

        if(session('got_ticket') === 3 && session('refund')) {
            $status['entrance'] = 4;
            $ticket['refund'] = session('refund');
        }

        return view('centaur.parking.parking')->with([
            'parking' => $parking,
            'status' => $status,
            'reservation' => $reservation,
            'has_reservation' => $has_reservation,
            'count' => $count,
            'ticket' => $ticket,
            'ticket_check' => $ticket_check,
            'exit_ticket_check' => $exit_ticket_check
        ]);
    }
}
