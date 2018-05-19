<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.role:administrator');
    }

    public function create()
    {
        return view('centaur.message');
    }

    public function form()
    {
        session()->flash('info', 'Message was sent.');

        return redirect()->route('dashboard');
    }
}
