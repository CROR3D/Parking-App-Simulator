<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProfileData;
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
        $user_data = [
            'id' => Sentinel::getUser()->id,
            'email' => Sentinel::getUser()->email,
            'username' => Sentinel::getUser()->username,
            'credit_card' => Sentinel::getUser()->credit_card
        ];

        return view('centaur.profile')->with('user_data', $user_data);
    }

    public function profile_form(StoreProfileData $request)
    {
        $user_id = Sentinel::getUser()->id;
        $user = User::findOrFail($user_id);

        $profile = [
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'credit_card' => $request->get('credit_card'),
            'account' => $request->get('account')
        ];

        $user->updateUser($profile);
        $user->save();

        session()->flash('info', 'Your profile information has been updated!');
        return redirect()->route('dashboard');
    }

    public function dashboard()
    {

        $c_list = Parking::select('city')->distinct()->orderBy('city', 'ASC')->get();
        $p_list = Parking::all();

        $data = null;

        if(Sentinel::check()) {
            $user_id = Sentinel::getUser()->id;
            $funds = User::find($user_id)->account;

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
                    'user_id' => $user_id,
                    'number' => Ticket::where('user_id', '<>', null)->count()
                ],
                'account' => [
                    'funds' => $funds
                ]
            ];
        }

        $admin_msg = true;

        return view('centaur.dashboard')->with(['data' => $data, 'admin_msg' => $admin_msg]);
    }
}
