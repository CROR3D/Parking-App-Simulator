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
        // CHECK IF EXPIRED RESERVATIONS EXIST AND DELETE THEM

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

        $form_buttons = [
            'enter',
            'ticket',
            'green',
            'reservation',
            'reservation_true',
            'payment',
            'back_to_parking',
            'already_got_ticket',
            'go_to_exit',
            'walk_out',
            'submit_ticket',
            'exit_submit_ticket',
            'submit_coins',
            'exit_success'
        ]

        dd($_POST);
    }
}
