<?php

namespace App\Http\Controllers;

use App\Models\Dialog;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Dialog $dialog)
    {
        $message = $dialog->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        $message->load('user');

        return response()->json([
            'message' => $message,
        ]);
    }

    public function fetchDialogMessages(Dialog $dialog, Request $request)
    {
        $lastCheck = $request->get('last_check', now()->subMinutes(10));

        $messages = $dialog->messages()
            ->where('created_at', '>', $lastCheck)
            ->with('user:id,name')
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
