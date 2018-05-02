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
                        return redirect()->route('parking_select', ['slug' => $slug]);
                    }
                } else {
                    session()->flash('error', 'This parking lot is full!');
                    return redirect()->route('parking_select', ['slug' => $slug]);
                }

            break;
            case (isset($_POST['other'])):
                return 'Its other button!';
            break;
        }
    }
}
