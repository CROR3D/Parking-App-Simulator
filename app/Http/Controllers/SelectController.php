<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use App\Models\Ticket;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Sentinel;
use Route;

class SelectController extends Controller
{
    public function __construct()
    {

        // PROVJERA POSTOJE LI REZERVACIJE koje su istekle (brišu se ako postoje) i naplata ako nisu validirane u zadanom roku

        $expire_time = Carbon::now();
        $expire = Reservation::where('expire_time', '<', $expire_time)->get();

        if($expire) {
            foreach($expire as $value) {
                if($value->penalty) {

                    $user_res = User::findOrFail($value->user_id);
                    $parking_res = Parking::findOrFail($value->parking_id);
                    $account_res = $user_res->account;

                    $user_arr = [
                        'account' => $account_res - $parking_res->price_of_reservation_penalty
                    ];

                    $user_res->updateUser($user_arr);
                    $user_res->save();
                }

                Reservation::where('user_id', $value->user_id)->delete();
            }
        }
    }

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

        $view = [
            'city_list' => $city_list,
            'parking_list' => $parking_list,
            'city_values' => $city_values,
            'parking_values' => $parking_values
        ];

        if(Route::current()->getName() == 'view') {

            return view('centaur.parking.view')->with($view);

        } elseif(Route::current()->getName() == 'simulator') {

            return view('simulator.select')->with($view);

        } elseif(Route::current()->getName() == 'update') {

            return view('centaur.parking.update_select')->with($view);
        }
    }

    public function index()
    {
            return view('index');
    }

    public function helper()
    {
            return view('simulator.helper');
    }

    public function get_parking()
    {
        $slug = $_POST['select'];

        if($slug) {

            $parking = Parking::where('slug', $slug)->first();

            if(Route::current()->getName() == 'view_form') {

                return redirect()->route('parking_view', ['slug' => $slug]);

            } elseif(Route::current()->getName() == 'post_simulator') {

                return redirect()->route('parking_select', ['slug' => $slug]);

            } elseif(Route::current()->getName() == 'update_select') {

                return redirect()->route('update_view', ['slug' => $slug]);
            }

        } else {

            session()->flash('info', 'Please select parking lot you want to enter.');

            if(Route::current()->getName() == 'view_form') {

                return redirect()->route('view');

            } elseif(Route::current()->getName() == 'post_simulator') {

                return redirect()->route('simulator');

            } elseif(Route::current()->getName() == 'update_form') {

               return redirect()->route('update');
           }
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

        $total = null;
        $ticket_check = null;
        $exit_ticket_check = null;

        $has_reservation = false;

        $reservation = [
            'code' => null,
            'expire' => null,
            'parking' => null
        ];

        if (Sentinel::check()) {
            $user_id = Sentinel::getUser()->id;

            if($res = Reservation::where('user_id', $user_id)->first()) {
                $reservation['code'] = $res->code;
                $reservation['expire'] = $res->expire_time;
                $reservation['parking'] = $res->parking_id;

                $has_reservation = true;
            }
        }

        // SLANJE PODATAKA PREKO SessionHelpera za rad Simulatora

        if(session('got_ticket') === 1) $status['entrance'] = 2;

        if(session('value')) $status['value'] = session('value');

        if(session('got_ticket') === 2) $status['entrance'] = 3;

        if(session('got_ticket') === 3) $status['entrance'] = 4;

        if(session('got_ticket') === 4) $status['entrance'] = 5;

        if(session('got_ticket') === 5) {
            $status['entrance'] = 5;
            $exit_ticket_check = session('exit_ticket_check');
            $status['exit'] = true;
        }

        if(session('got_ticket') === 3 && session('price')) {
            $status['entrance'] = 4;
            $total = session('total');
            $ticket['price'] = session('price');
            $ticket_check = session('ticket_check');
        }

        if(session('got_ticket') === 3 && session('refund')) {
            $status['entrance'] = 4;
            $ticket['refund'] = session('refund');
        }

        $parking_view = [
            'parking' => $parking,
            'status' => $status,
            'reservation' => $reservation,
            'has_reservation' => $has_reservation,
            'count' => $count,
            'ticket' => $ticket,
            'total' => $total,
            'ticket_check' => $ticket_check,
            'exit_ticket_check' => $exit_ticket_check
        ];

        if(Route::current()->getName() == 'parking_view') {

            return view('centaur.parking.parking')->with($parking_view);

        } elseif (Route::current()->getName() == 'parking_select') {

            return view('simulator.parking')->with($parking_view);

        }
    }
}
