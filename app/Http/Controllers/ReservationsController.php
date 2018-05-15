<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Parking;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Sentinel;

class ReservationsController extends Controller
{

    public function __construct()
    {

        // PROVJERA POSTOJE LI REZERVACIJE koje su istekle (brišu se ako postoje)

        $expire_time = Carbon::now();
        $expire = Reservation::where('expire_time', '<', $expire_time)->get();

        if($expire) {
            foreach($expire as $value) {
                Reservation::where('user_id', $value->user_id)->delete();
            }
        }
    }

    public function reservations($slug)
    {

        $parking = Parking::where('slug', $slug)->first();
        $spots_total = $parking->spots;
        $spots_current = Ticket::where('parking_id', $parking->id)->count();
        $spots_reserved = Reservation::where('parking_id', $parking->id)->count();
        $spots_taken = $spots_current + $spots_reserved;
        $parking_id = $parking->id;
        $reservation_price = $parking->price_of_reservation;

        $user_id = Sentinel::getUser()->id;
        $reservation_price = $parking->price_of_reservation;
        $penalty_price = $parking->price_of_reservation_penalty;
        $user = User::findOrFail($user_id);
        $account = $user->account;

        switch(true) {
            case(isset($_POST['reservation'])):

                $check_spots = Ticket::where('user_id', $user_id)->first();

                if($spots_taken < $spots_total && !$check_spots) {

                    $reservation = array(
                        'user_id' => $user_id,
                        'parking_id' => $parking->id,
                        'code' => sprintf('%04d', rand(0000, 9999)),
                        'cancellation' => Carbon::now()->addMinute(10),
                        'expire_time' => Carbon::now()->addMinute(30)
                    );

                    if(Reservation::where('user_id', $reservation['user_id'])->first()) {

                        session()->flash('info', 'You already have reservation!');

                    } elseif($account <= ($reservation_price + $penalty_price)) {

                        session()->flash('info', 'You don\'t have enough money to make reservation and take possible penalty!');

                    }else {
                        $new_reservation = new Reservation;
                        $data = $new_reservation->saveReservation($reservation);

                        session()->flash('info', 'New reservation created in ' . $parking->city . ' (' . $parking->name . ')!');

                    }

                } elseif($check_spots) {

                    session()->flash('error', 'Can\'t reserve spot! Your pressence is already located in ' . $parking->city . ' (' . $parking->name . ')!');

                } else {

                    session()->flash('error', 'This parking lot is full!');

                }

                return redirect()->route('parking_view', ['slug' => $slug]);

            break;

            case(isset($_POST['reservation_true'])):

                $res = Reservation::where('user_id', $user_id)->first();
                $cancellation = $res->cancellation;

                if(Carbon::now() > $cancellation) {

                    $profile = [
                        'account' => $account - $penalty_price
                    ];

                    $user->updateUser($profile);
                    $user->save();

                }

                Reservation::where('user_id', Sentinel::getUser()->id)->delete();

                session()->flash('info', 'Reservation canceled in ' . $parking->city . ' (' . $parking->name . ')!');
                return redirect()->route('parking_view', ['slug' => $slug]);

            break;
        }
    }
}
