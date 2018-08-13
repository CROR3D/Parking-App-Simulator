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

    private $slug;
    private $parking;
    private $spots_total;
    private $spots_current;
    private $spots_reserved;
    private $spots_taken;
    private $parking_id;
    private $reservation_price;
    private $user_id;
    private $penalty_price;
    private $user;
    private $account;

    public function __construct()
    {
        return self::deleteExpiredReservations();
    }

    public function reservations($slug)
    {

        $this->slug = $slug;
        $this->parking = Parking::where('slug', $slug)->first();
        $this->spots_total = $this->parking->spots;
        $this->spots_current = Ticket::where('parking_id', $this->parking->id)->count();
        $this->spots_reserved = Reservation::where('parking_id', $this->parking->id)->count();
        $this->spots_taken = $this->spots_current + $this->spots_reserved;
        $this->parking_id = $this->parking->id;
        $this->reservation_price = $this->parking->price_of_reservation;

        $this->user_id = Sentinel::getUser()->id;
        $this->reservation_price = $this->parking->price_of_reservation;
        $this->penalty_price = $this->parking->price_of_reservation_penalty;
        $this->user = User::findOrFail($this->user_id);
        $this->account = $this->user->account;

        switch(true) {
            case(isset($_POST['reservation'])):
                return $this->createReservation();
                break;

            case(isset($_POST['reservation_true'])):
                return $this->cancelReservation();
                break;
        }
    }

    public static function deleteExpiredReservations() {

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

    private function createReservation() {

        $check_spots = Ticket::where('user_id', $this->user_id)->first();

        $code = sprintf('%04d', rand(0000, 9999));

        while(Reservation::where('code', $code)->where('parking_id', $this->parking->id)->first()) {
            $code = sprintf('%04d', rand(0000, 9999));
        }

        if($this->spots_taken < $this->spots_total && !$check_spots) {

            $reservation = array(
                'user_id' => $this->user_id,
                'parking_id' => $this->parking->id,
                'code' => $code,
                'cancellation' => Carbon::now()->addMinute(10),
                'expire_time' => Carbon::now()->addMinute(30)
            );

            if(Reservation::where('user_id', $reservation['user_id'])->first()) {

                session()->flash('info', 'You already have reservation!');

            } elseif($this->account <= ($this->reservation_price + $this->penalty_price)) {

                session()->flash('info', 'You don\'t have enough money on your account to make this reservation!');

            } else {

                $new_reservation = new Reservation;
                $new_reservation->saveReservation($reservation);

                $user_acc = [
                    'account' => $this->account - $this->reservation_price
                ];

                $this->user->updateUser($user_acc);
                $this->user->save();

                session()->flash('info', 'New reservation created in ' . $this->parking->city . ' (' . $this->parking->name . ')!');

            }

        } elseif($check_spots) {

            session()->flash('error', 'Can\'t reserve spot! Your pressence is already located in ' . $this->parking->city . ' (' . $this->parking->name . ')!');

        } else {

            session()->flash('error', 'This parking lot is full!');

        }

        return redirect()->route('parking_view', ['slug' => $this->slug]);
    }

    private function cancelReservation() {

        $res = Reservation::where('user_id', $this->user_id)->first();
        $cancellation = $res->cancellation;

        if(Carbon::now() <= $cancellation) {

            $profile = [
                'account' => $this->account + $this->reservation_price
            ];

            $refund = true;

        } else {

            $profile = [
                'account' => $this->account - $this->penalty_price
            ];

            $refund = false;

        }

        $error = array(
            'user_id' => $this->user_id,
            'about' => 'cancellation',
            'expire_time' => Carbon::now()->addMinute(10)
        );

        $new_error = new Error;
        $new_error->saveError($error);

        $this->user->updateUser($profile);
        $this->user->save();

        Reservation::where('user_id', Sentinel::getUser()->id)->delete();

        if($refund) {
            session()->flash('info', 'Reservation canceled in ' . $this->parking->city . ' (' . $this->parking->name . ')! You got ' . $this->reservation_price . ' kn back.');
        } else {
            session()->flash('info', 'Reservation canceled in ' . $this->parking->city . ' (' . $this->parking->name . ')! You got ' . $this->penalty_price . ' kn penalty.');
        }

        return redirect()->route('parking_view', ['slug' => $this->slug]);
    }
}
