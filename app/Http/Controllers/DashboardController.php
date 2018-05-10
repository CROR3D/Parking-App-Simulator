<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;
use App\Models\Ticket;
use App\Models\Reservation;
use Carbon\Carbon;
use Sentinel;

class DashboardController extends Controller
{
    public function profile_setup()
    {
        $user_data = [
            'id' => Sentinel::getUser()->id,
            'email' => Sentinel::getUser()->email,
            'username' => Sentinel::getUser()->username
        ];

        return view('centaur.profile')->with('user_data', $user_data);
    }

    public function dashboard()
    {

        $c_list = Parking::select('city')->distinct()->orderBy('city', 'ASC')->get();
        $p_list = Parking::all();

        $data = [
            'cities' => [
                'list' => $c_list,
                'number' => $c_list->count()
            ],
            'parkings' => [
                'list' => $p_list,
                'number' => $p_list->count()
            ],
            'users' => [
                'number' => Ticket::where('user_id', '<>', null)->count()
            ]
        ];

        $admin_msg = true;

        return view('centaur.dashboard')->with(['data' => $data, 'admin_msg' => $admin_msg]);
    }
}
