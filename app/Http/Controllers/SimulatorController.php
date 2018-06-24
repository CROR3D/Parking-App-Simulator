<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\Parking;
use App\Models\Temp_User;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
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
                    $entrance = Carbon::createFromTimeString($my_ticket->entrance_time);
                    $now = Carbon::now();

                    $price_hour = $parking->price_per_hour;

                    // BROJ DANA koliko je automobil na parkiralištu
                    $days_e = $entrance->diffInDays($now);

                    $working = explode('-', $parking->working_time);
                    $start_time = new DateTime($working[0]);
                    $end_time = new DateTime($working[1]);

                    $interval = $start_time->diff($end_time);

                    dd($now, $entrance, $days_e, $start_time, $end_time, $interval->format("%H"));

                    // PRETVARANJE RADNOG VREMENA u brojeve (za usporedbu s vremenom na karti)
                    $working = explode('-', $parking->working_time);
                    $start_time = str_replace(":", ".", $working[0]);
                    $start_arr = explode(".", $start_time);
                    $start_h = (int) $start_arr[0];
                    $start_m = (int) $start_arr[1];
                    $end_time = str_replace(":", ".", $working[1]);
                    $end_arr = explode(".", $end_time);
                    $end_h = (int) $end_arr[0];
                    $end_m = (int) $end_arr[1];
                    $start = number_format($start_time, 2);
                    $end = number_format($end_time, 2);

                    // PRETVARANJE VREMENA NA KARTI u brojeve (za usporedbu s radnim vremenom)
                    $entr = date('H:i', $entrance);
                    $entr_time = str_replace(":", ".", $entr);
                    $entr_arr = explode(".", $entr_time);
                    $entr_h = (int) $entr_arr[0];
                    $entr_m = (int) $entr_arr[1];
                    $entr = number_format($entr_time, 2);
                    $paid_end = date('H:i', $now);

                    $hours = 0;

                    // TIME LAPSE
                    if(array_filter($time_lapse)) {
                        $days_count = ($time_lapse['days']) ? $time_lapse['days'] : 0;
                        $days = ($time_lapse['days']) ? $time_lapse['days'] : 0;
                        $total_hours = ($time_lapse['hours']) ? $time_lapse['hours'] : 0;
                        $minutes = ($time_lapse['minutes']) ? $time_lapse['minutes'] : 0;
                        $date2 = date_create(date('Y-m-d h:m:s', strtotime('+' . $days . ' days, +' . $total_hours . ' hours, +' . $minutes . ' minutes')));

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
                            $days = $days_count + $add_days;
                        }

                        $paid_end = date("H:i", strtotime('+' . $total_hours . ' hours'));

                        $time_lapse['total'] = $days . ' days, ' . $total_hours . ' hours and ' . $minutes . ' minutes.';
                    }

                    $paid_time = str_replace(":", ".", $paid_end);
                    $paid_arr = explode(".", $paid_time);
                    $paid_h = (int) $paid_arr[0];
                    $paid_m = (int) $paid_arr[1];
                    $paid_end = number_format($paid_time, 2);

                    $date3 = date_diff($date1,$date2);
                    $days_count = $date3->days + 1;

                    // IZRAČUN KOLIKO JE AUTOMOBIL BIO SATI U NAPLATNOM VREMENU PARKIRALIŠTA (trebao bi naći jednostavniji i bolji način za ovo)
                    for($i = 1; $i <= $days_count; $i++) {
                        if($days_count == 1) {
                            if($entr >= $start && $entr <= $end) {
                                if($paid_end < $end) {
                                    if($paid_m > $entr_m) {
                                        $add = (float) (($paid_h - $entr_h) . '.' . ($paid_m - $entr_m));
                                    } else {
                                        $min = (60 - $entr_m) + $paid_m;
                                        $add = (float) (($paid_h - $entr_h) . '.' . $min);
                                    }
                                    $hours += ceil($add);
                                } else {
                                    if($end_m > $entr_m) {
                                        $add = (float) (($end_h - $entr_h) . '.' . ($end_m - $entr_m));
                                    } else {
                                        $min = (60 - $entr_m) + $end_m;
                                        $add = (float) (($end_h - $entr_h) . '.' . $min);
                                    }
                                    $hours += ceil($add);
                                }
                            } else {
                                if($entr < $start) {
                                    if($paid_end < $end) {
                                        if($paid_m > $start_m) {
                                            $add = (float) (($paid_h - $start_h) . '.' . ($paid_m - $start_m));
                                        } else {
                                            $min = (60 - $start_m) + $paid_m;
                                            $add = (float) (($paid_h - $start_h) . '.' . $min);
                                        }
                                        $hours += ceil($add);
                                    } else {
                                        if($end_m > $start_m) {
                                            $add = (float) (($end_h - $start_h) . '.' . ($end_m - $start_m));
                                        } else {
                                            $min = (60 - $start_m) + $end_m;
                                            $add = (float) (($end_h - $start_h) . '.' . $min);
                                        }
                                        $hours += ceil($add);
                                    }
                                } else {
                                    break;
                                }
                            }
                            break;
                        } else {
                            if($i == 1) {
                                if($entr >= $start && $entr <= $end) {
                                    if($end_m > $entr_m) {
                                        $add = (float) (($end_h - $entr_h) . '.' . ($end_m - $entr_m));
                                    } else {
                                        $min = (60 - $entr_m) + $end_m;
                                        $add = (float) (($end_h - $entr_h) . '.' . $min);
                                    }
                                    $hours += ceil($add);
                                } else {
                                    if($entr < $start) {
                                        if($end_m > $start_m) {
                                            $add = (float) (($end_h - $start_h) . '.' . ($end_m - $start_m));
                                        } else {
                                            $min = (60 - $start_m) + $end_m;
                                            $add = (float) (($end_h - $start_h) . '.' . $min);
                                        }
                                        $hours += ceil($add);
                                    }
                                }
                            }

                            if($i > 1 && $i < $days_count) {
                                $add1 = (float) (($end_h - $start_h) . '.' . ($end_m - $start_m));
                                $hours += ceil($add1);
                            }

                            if($i == $days_count) {
                                if($paid_end >= $start && $paid_end <= $end) {
                                    $add2 = (float) (($paid_h - $start_h) . '.' . ($paid_m - $start_m));
                                    $hours += ceil($add2);
                                } elseif($paid_end < $start) {
                                    $hours += 0;
                                } else {
                                    $add2 = (float) (($end_h - $start_h) . '.' . ($end_m - $start_m));
                                    $hours += ceil($add2);
                                }
                            }
                        }
                    }

                    if ($hours == 0) $hours = 1;
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
