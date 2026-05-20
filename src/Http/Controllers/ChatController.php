<?php

namespace Harman\ReverbChat\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Harman\ReverbChat\Events\MessageSent;
use Harman\ReverbChat\Models\Message;

class ChatController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);

        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $user->id);
        })
        ->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', Auth::id());
        })
        ->orderBy('id')
        ->get();

        $users = User::where('id', '!=', Auth::id())->get();

        return view('reverb-chat::index', compact('messages', 'user', 'users'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message'     => 'required',
        ]);

        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(
            $message->load('sender')
        );
    }
}