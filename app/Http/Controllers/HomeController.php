<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Message;
use Pusher;
use App\Events\MyEvent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('home', ['users' => $users]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();
        $messages = Message::where( function($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->orWhere(function($query) use ($user_id, $my_id){
            $query->where('from', $user_id)->where('to', $my_id);
        })->get();

        //$messages = $messages->to();
        $users = User::where('id', '!=', Auth::id())->get();

        return view('messages.index', ['messages' => $messages]);
    }
    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        $options = array(
            'cluster' => 'ap2',
            'useTLS' => false
          );
          $pusher = new Pusher\Pusher(
            '82fb561db49772b8967c',
            '32a171d877d055ea5285',
            '931011',
            $options
          );
        
        $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}