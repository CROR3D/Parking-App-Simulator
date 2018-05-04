<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\Parking;
use App\Models\Temp_User;
use App\Models\User;
use Carbon\Carbon;
use Sentinel;

class SimulatorController extends Controller
{
    public function __construct()
    {
        // Provjera postoje li rezervacije koje su istekle (brišu se ako postoje)

        $expire_time = Carbon::now();
        $expire = Reservation::where('expire_time', '<', $expire_time)->get();

        if($expire) {
            foreach($expire as $value) {
                Reservation::where('user_id', $value->user_id)->delete();
            }
        }
    }

    public function parking_form($slug)
    {

        $parking = Parking::where('slug', $slug)->first();
        $spots_total = $parking->spots;
        $spots_current = Ticket::where('parking_id', $parking->id)->count();
        $spots_reserved = Reservation::where('parking_id', $parking->id)->count();
        $spots_taken = $spots_current + $spots_reserved;

        //

        switch(true) {
            case (isset($_POST['enter'])):

                if($spots_taken < $spots_total || $spots_reserved > 0) {

                    // CHECK IF RESERVATION EXISTS

                    $code = $_POST['screen'];

                    if(Reservation::where('code', $code)->where('parking_id', $parking->id)->first()) {
                        $user_id = Reservation::where('code', $code)->where('parking_id', $parking->id)->first()->user_id;

                        $value = $user_id . 'R' . rand();
                        $got_ticket = 1;

                        Reservation::where('code', $code)->delete();

                        session()->flash('info', 'New ticket created in ' . $parking->city . ' (' . $parking->name . ')!');
                        return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket, 'value' => $value]);

                    } else {
                        session()->flash('error', 'Invalid code! Try again.');
                    }
                } else {
                    session()->flash('error', 'This parking lot is full!');
                }

                return redirect()->route('parking_select', ['slug' => $slug]);

            break;

            case (isset($_POST['ticket'])):

                if($spots_taken < $spots_total) {

                    $value = rand();
                    $got_ticket = 1;

                    return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket, 'value' => $value]);

                } else {

                    session()->flash('error', 'This parking lot is full!');
                    return redirect()->route('parking_select', ['slug' => $slug]);

                }

            break;

            case(isset($_POST['green'])):

                $ticket_value = $_POST['display_ticket'];
                $got_ticket = 2;

                if(is_numeric($ticket_value)) {
                    // CREATE NEW TEMP_USER

                    $temp_user = [];

                    $new_temp_user = new Temp_User;
                    $user_data = $new_temp_user->saveTempUser($temp_user);
                    $temp_id = $user_data->id;

                    // CREATE NEW TICKET with temp_user

                    $ticket = array(
                        'user_id' => null,
                        'temp_user_id' => $temp_id,
                        'parking_id' => $parking->id,
                        'code' => $ticket_value,
                        'paid' => false,
                        'entrance_time' => Carbon::now(),
                        'bonus_time' => null
                    );

                } else {

                    // CREATE NEW TICKET with registered_user

                    $arr = explode('R', $ticket_value);
                    $user_id = $arr[0];

                    $ticket = array(
                        'user_id' => $user_id,
                        'temp_user_id' => null,
                        'parking_id' => $parking->id,
                        'code' => $ticket_value,
                        'paid' => false,
                        'entrance_time' => Carbon::now(),
                        'bonus_time' => null
                    );

                }

                $new_ticket = new Ticket;
                $data = $new_ticket->saveTicket($ticket);

                return redirect()->route('parking_select', ['slug' => $slug])->with('got_ticket', $got_ticket);

            break;

            case(isset($_POST['payment'])):

                $got_ticket = 3;
                return redirect()->route('parking_select', ['slug' => $slug])->with('got_ticket', $got_ticket);

            break;
        }
    }
}
