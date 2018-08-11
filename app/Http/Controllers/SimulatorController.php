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

    public function parking_form($slug)
    {

        $parking = Parking::where('slug', $slug)->first();
        $spots_total = $parking->spots;
        $spots_current = Ticket::where('parking_id', $parking->id)->count();
        $spots_reserved = Reservation::where('parking_id', $parking->id)->count();
        $spots_taken = $spots_current + $spots_reserved;

        switch(true) {
            case (isset($_POST['enter'])):

                if($spots_taken < $spots_total || $spots_reserved > 0) {

                    // PROVJERA postoji li rezervacija (ako postoji briše se nakon unosa)

                    $code = $_POST['screen'];

                    $res_exists = Reservation::where('code', $code)->where('parking_id', $parking->id)->first();

                    if($res_exists && strlen((string) $code) == 4) {
                        $user_id = $res_exists->user_id;

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

                    while(Ticket::where('code', $value)->first()) {
                        $value = rand();
                    }

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

                    // STVARANJE PRIVREMENOG KORISNIKA

                    $temp_user = [];

                    $new_temp_user = new Temp_User;
                    $user_data = $new_temp_user->saveTempUser($temp_user);
                    $temp_id = $user_data->id;

                    // STVARANJE NOVE KARTE s privremenim korisnikom

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

                    // STVARANJE NOVE KARTE s registriranim korisnikom

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

            case(isset($_POST['back_to_parking'])):
            case(isset($_POST['already_got_ticket'])):

            if($spots_current > 0) {

                $got_ticket = 2;
                return redirect()->route('parking_select', ['slug' => $slug])->with('got_ticket', $got_ticket);

            } else {

                session()->flash('error', 'This parking lot is empty!');
                return redirect()->route('parking_select', ['slug' => $slug]);
            }

            break;

            case(isset($_POST['go_to_exit'])):

                $got_ticket = 4;
                return redirect()->route('parking_select', ['slug' => $slug])->with('got_ticket', $got_ticket);

            break;

            case(isset($_POST['walk_out'])):

                $got_ticket = 0;
                return redirect()->route('parking_select', ['slug' => $slug])->with('got_ticket', $got_ticket);

            break;

            case(isset($_POST['submit_ticket'])):

                $got_ticket = 3;
                $ticket_check = $_POST['insert_ticket'];
                $my_ticket = Ticket::where('code', $ticket_check)->where('parking_id', $parking->id)->first();

                $time_lapse = [
                    'days' => $_POST['parking_days'],
                    'hours' => $_POST['parking_hours'],
                    'minutes' => $_POST['parking_minutes'],
                    'total' => $_POST['parking_time']
                ];

                if($my_ticket != null) {
                    $is_paid = $my_ticket->paid;
                } else {
                    session()->flash('error', 'Invalid ticket code!');
                    return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket]);
                }

                if($ticket_check && $is_paid == false) {
                    // VRIJEME ULAZA AUTOMOBILA
                    $entrance = Carbon::createFromTimeString($my_ticket->entrance_time);

                    // VRIJEME PLAĆANJA KARTE
                    $now = Carbon::now();

                    $working = explode('-', $parking->working_time);

                    // POČETAK RADNOG VREMENA
                    $start_time = Carbon::createFromFormat('H:i', $working[0]);

                    // KRAJ RADNOG VREMENA
                    $end_time = Carbon::createFromFormat('H:i', $working[1]);

                    // CIJENA KARTE
                    $price_hour = $parking->price_per_hour;

                    // BROJ NAPLATNIH SATI i minuta
                    $hours = 0;
                    $add_minutes = 0;

                    // TIME LAPSE
                    if(array_filter($time_lapse)) {
                        $days_count = ($time_lapse['days']) ? $time_lapse['days'] : 0;
                        $total_hours = ($time_lapse['hours']) ? $time_lapse['hours'] : 0;
                        $minutes = ($time_lapse['minutes']) ? $time_lapse['minutes'] : 0;
                        $date2 = date_create(date('Y-m-d h:m:s', strtotime('+' . $days_count . ' days, +' . $total_hours . ' hours, +' . $minutes . ' minutes')));

                        if($minutes >= 60) {
                            $add_hours = floor($minutes / 60);
                            $minutes = $minutes % 60;
                            if($minutes > 0) {
                                $total_hours = $total_hours + $add_hours + 1;
                            } else {
                                $total_hours = $total_hours + $add_hours;
                            }
                        }

                        if($total_hours >= 24) {
                            $add_days = floor($total_hours / 24);
                            $total_hours = $total_hours % 24;
                            $days_count = $days_count + $add_days;
                        }

                        function plural($x) {
                            if($x != 1) return 's';
                        }

                        $now = $now->addHours($total_hours)->addMinutes($minutes);

                        $time_lapse['total'] = $days_count . ' day' . plural($days_count) . ', ' . $total_hours  . ' hour' . plural($total_hours) . ', and ' . $minutes . ' minute' . plural($total_hours) . '.';
                    }

                    // IZRAČUN KOLIKO JE NAPLATNIH SATI automobil bio na parkiralištu
                    while ($entrance <= $now) {

                        $hour = $entrance->format('H:i');
                        $time = Carbon::createFromFormat('H:i', $hour);

                        if($time >= $start_time && $time < $end_time) {

                            if($start_time->diffInMinutes($time) < 60) {
                                $add_minutes += $start_time->diffInMinutes($time);
                            } else if($end_time->diffInMinutes($time) < 60) {
                                $hours++;
                                $add_minutes += $end_time->diffInMinutes($time);
                            } else {
                                $hours++;
                            }
                        }

                        $entrance->addHour();
                    }

                    $h = floor($add_minutes / 60);
                    if(($add_minutes % 60) > 0) $hours += 1;

                    $hours = $hours + $h;

                    if ($hours < 1) $hours = 1;
                    $price = ceil($hours) * $price_hour;

                    $price = $price . ' kn';

                    return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket, 'ticket_check' => $ticket_check, 'price' => $price, 'total' => $time_lapse['total']]);

                } elseif($ticket_check && $is_paid == true) {

                    session()->flash('info', 'This ticket is already paid.');

                } else {

                    session()->flash('info', 'Please insert ticket.');
                }

                return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket]);


            break;

            case(isset($_POST['submit_coins'])):

                $got_ticket = 3;
                $coin_check = $_POST['insert_coins'];
                $price = $_POST['payment_screen'];
                $drop_kn = explode(' kn', $price);
                $price_check = (int)$drop_kn[0];
                $ticket_check = $_POST['insert_ticket'];

                if(is_numeric($coin_check)) {

                    if($coin_check > $price_check) {
                        $refund = $coin_check - $price_check;
                        $refund = $refund . ' kn';
                    } elseif ($coin_check == $price_check) {
                        $refund = 0;
                    } elseif ($coin_check < $price_check) {

                        session()->flash('info', 'Please insert more coins.');
                        return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket]);
                    }

                    $update_ticket = Ticket::where('code', $ticket_check)->update([
                        'paid' => true,
                        'bonus_time' => Carbon::now()->addMinute(10)
                    ]);

                    session()->flash('info', 'Ticket has been successfully paid.');
                    return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket, 'refund' => $refund]);
                } else {

                    session()->flash('error', 'Insert coins please!');
                    return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket]);
                }

            break;

            case(isset($_POST['exit_submit_ticket'])):

                $got_ticket = 4;
                $exit_ticket_check = $_POST['exit_insert_ticket'];
                $my_ticket = Ticket::where('code', $exit_ticket_check)->first();

                if($my_ticket != null) {
                    $is_paid = $my_ticket->paid;
                    $bonus_time = strtotime($my_ticket->bonus_time);
                    $now = strtotime(Carbon::now()->toDateTimeString());
                    $penalty = $bonus_time - $now;
                } else {
                    session()->flash('error', 'Invalid ticket code!');
                    return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket]);
                }

                if($exit_ticket_check && $is_paid == true && $penalty > 0) {
                    $got_ticket = 5;

                    session()->flash('info', 'You may leave parking lot!');
                    return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket, 'exit_ticket_check' => $exit_ticket_check]);

                } elseif($exit_ticket_check && $is_paid == true && $penalty < 0) {

                    $update_ticket = Ticket::where('code', $exit_ticket_check)->update([
                        'entrance_time' => $my_ticket->bonus_time,
                        'paid' => false,
                        'bonus_time' => null,
                        'price' => null
                    ]);

                    session()->flash('warning', 'Your 10 minutes to exit have passed! You must pay your ticket again!');

                } elseif($exit_ticket_check && $is_paid == false) {

                    session()->flash('error', 'This ticket has not been paid yet!');

                }

                return redirect()->route('parking_select', ['slug' => $slug])->with(['got_ticket' => $got_ticket]);

            break;

            case(isset($_POST['exit_success'])):

                $exit_ticket_check = $_POST['exit_insert_ticket'];

                if($t_user = Ticket::where('code', $exit_ticket_check)->first()->temp_user_id) {
                    $delete_temp_user = Temp_User::where('id', $t_user)->delete();
                }

                $delete = Ticket::where('code', $exit_ticket_check)->delete();

                session()->flash('info', 'You have left \'' . $parking->name . '\' (' . $parking->city . ') parking lot!');
                return redirect()->route('simulator');

            break;
        }
    }
}
