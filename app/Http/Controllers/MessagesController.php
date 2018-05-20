<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMessage;
use App\Models\Message;
use Sentinel;

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

    public function form(StoreMessage $request)
    {
        $message = array(
            'user_id' => Sentinel::getUser()->id,
            'title' => $request->get('title'),
            'content' => $request->get('content')
        );

        $new_message = new Message;
        $new_message->saveMessage($message);

        session()->flash('info', 'Message was announced to all users.');
        return redirect()->route('dashboard');
    }
}
