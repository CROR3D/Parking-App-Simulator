<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Parking;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Error;
use Carbon\Carbon;
use Sentinel;

class ReservationsController extends Controller
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

        // brisanje grešaka ako postoje u Error table

        Error::where('expire_time', '<', $expire_time)->delete();
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

                $code = sprintf('%04d', rand(0000, 9999));

                while(Reservation::where('code', $code)->where('parking_id', $parking->id)->first()) {
                    $code = sprintf('%04d', rand(0000, 9999));
                }

                if($spots_taken < $spots_total && !$check_spots) {

                    $reservation = array(
                        'user_id' => $user_id,
                        'parking_id' => $parking->id,
                        'code' => $code,
                        'cancellation' => Carbon::now()->addMinute(10),
                        'expire_time' => Carbon::now()->addMinute(30)
                    );

                    if(Reservation::where('user_id', $reservation['user_id'])->first()) {

                        session()->flash('info', 'You already have reservation!');

                    } elseif($account <= ($reservation_price + $penalty_price)) {

                        session()->flash('info', 'You don\'t have enough money on your account to make this reservation!');

                    } else {

                        $new_reservation = new Reservation;
                        $new_reservation->saveReservation($reservation);

                        $user_acc = [
                            'account' => $account - $reservation_price
                        ];

                        $user->updateUser($user_acc);
                        $user->save();

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

                if(Carbon::now() <= $cancellation) {

                    $profile = [
                        'account' => $account + $reservation_price
                    ];

                    $refund = true;

                } else {

                    $profile = [
                        'account' => $account - $penalty_price
                    ];

                    $refund = false;

                }

                $error = array(
                    'user_id' => $user_id,
                    'about' => 'cancellation',
                    'expire_time' => Carbon::now()->addMinute(10)
                );

                $new_error = new Error;
                $new_error->saveError($error);

                $user->updateUser($profile);
                $user->save();

                Reservation::where('user_id', Sentinel::getUser()->id)->delete();

                if($refund) {
                    session()->flash('info', 'Reservation canceled in ' . $parking->city . ' (' . $parking->name . ')! You got ' . $reservation_price . ' kn back.');
                } else {
                    session()->flash('info', 'Reservation canceled in ' . $parking->city . ' (' . $parking->name . ')! You got ' . $penalty_price . ' kn penalty.');
                }

                return redirect()->route('parking_view', ['slug' => $slug]);

            break;
        }
    }
}
