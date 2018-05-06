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

        return view('centaur.dashboard')->with('data', $data);
    }
}
