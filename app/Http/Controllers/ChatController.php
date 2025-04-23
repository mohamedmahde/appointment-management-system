<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all();
        $messages = collect();
        if ($users->count() > 0) {
            $firstUser = $users->first();
            $messages = \App\Models\Message::where(function($q) use ($firstUser) {
                $q->where('sender_id', auth()->id())->where('receiver_id', $firstUser->id);
            })->orWhere(function($q) use ($firstUser) {
                $q->where('sender_id', $firstUser->id)->where('receiver_id', auth()->id());
            })->orderBy('created_at')->with(['sender', 'receiver'])->get();
        }
        return view('chat.index', compact('users', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id',
        ]);
        $receiver_id = $request->input('receiver_id');
        \App\Models\Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver_id,
            'message' => $request->message,
        ]);
        return response()->json(['success' => true]);
    }

    public function fetchMessages(\App\Models\User $user)
    {
        // Debug log
        $allUserIds = \App\Models\User::pluck('id')->toArray();
        \Log::info('fetchMessages debug', [
            'requested_user_id' => $user->id,
            'auth_user_id' => auth()->id(),
            'all_user_ids' => $allUserIds
        ]);
        // السماح بالمحادثة مع أي مستخدم بما فيهم نفسك
        $messages = \App\Models\Message::where(function($q) use ($user) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
        })->orderBy('created_at')->with(['sender', 'receiver'])->get();
        return response()->json(['messages' => $messages]);
    }
}
