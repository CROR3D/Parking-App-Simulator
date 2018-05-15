<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProfile;
use App\Models\User;
use App\Models\Parking;
use App\Models\Ticket;
use App\Models\Reservation;
use Carbon\Carbon;
use Sentinel;

class DashboardController extends Controller
{
    public function profile_setup()
    {
        $data = [
            'id' => Sentinel::getUser()->id,
            'email' => Sentinel::getUser()->email,
            'username' => Sentinel::getUser()->username,
            'credit_card' => Sentinel::getUser()->credit_card,
            'account' => Sentinel::getUser()->account
        ];

        return view('centaur.profile')->with('data', $data);
    }

    public function profile_form(StoreProfile $request)
    {
        $user_id = Sentinel::getUser()->id;
        $account = Sentinel::getUser()->account;
        $user = User::findOrFail($user_id);

        $profile = [
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'credit_card' => $request->get('credit_card'),
            'account' => $account + $request->get('account')
        ];

        $user->updateUser($profile);
        $user->save();

        session()->flash('info', 'Your profile information has been updated!');
        return redirect()->route('dashboard');
    }

    public function show($data)
    {

        switch($data) {
            case 'cities':

                $c_list = Parking::select('city')->distinct()->orderBy('city', 'ASC')->get();

                $info = [
                    'title' => 'List of cities supporting application',
                    'id' => 'city',
                    'data' => $c_list
                ];

            break;

            case 'parking':

                $p_list = Parking::select('*')->orderBy('city', 'ASC')->get();

                $info = [
                    'title' => 'List of parking lots supporting application',
                    'id' => 'parking',
                    'data' => $p_list
                ];

            break;

            case 'users':

                $t_list = Ticket::where('user_id', '<>', null)->get();
                $p_list = Parking::select('*')->orderBy('city', 'ASC')->get();
                $u_list = User::all();

                $info = [
                    'title' => 'List of registered users on parking lots',
                    'id' => 'users',
                    'data' => $t_list,
                    'users' => $u_list,
                    'lots' => $p_list
                ];

            break;
        }

        return view('centaur.show')->with('info', $info);
    }

    public function dashboard()
    {

        $c_list = Parking::select('city')->distinct()->orderBy('city', 'ASC')->get();
        $p_list = Parking::all();

        $city = [];

        foreach ($p_list as $parking) {
            array_push($city, $parking->city);
        }

        $values = array_count_values($city);
        arsort($values);
        $c_most_lots = array_slice(array_keys($values), 0, 1, true);

        $data = null;

        if(Sentinel::check()) {

            $user_id = Sentinel::getUser()->id;
            $account = User::find($user_id)->account;
            $credit_card = User::find($user_id)->credit_card;

            $data = [
                'cities' => [
                    'list' => $c_list,
                    'number' => $c_list->count(),
                    'most_lots' => $c_most_lots[0]
                ],
                'parkings' => [
                    'list' => $p_list,
                    'number' => $p_list->count()
                ],
                'users' => [
                    'user_id' => $user_id,
                    'number' => Ticket::where('user_id', '<>', null)->count()
                ],
                'account' => $account,
                'credit_card' => $credit_card
            ];
        }

        $admin_msg = true;

        return view('centaur.dashboard')->with(['data' => $data, 'admin_msg' => $admin_msg]);
    }
}
