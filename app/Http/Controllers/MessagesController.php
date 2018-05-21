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
        return view('centaur.messages.message');
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

    public function view()
    {
        $messages = Message::all();

        return view('centaur.messages.view')->with('messages', $messages);
    }

    public function message($id)
    {
        $message = Message::findOrFail($id);

        return view('centaur.messages.content')->with('message', $message);
    }

    public function delete($id)
    {
        $message = Message::findOrFail($id);

        if(Sentinel::getUser()->id === $message->user_id || Sentinel::inRole('administrator')) {
            $message->delete();
        } else {
            session()->flash('info', 'You can\'t delete this message');
            return redirect()->route('dashboard');
        }
        session()->flash('success', 'You have successfully deleted a message');
        return redirect()->route('dashboard');
    }
}
