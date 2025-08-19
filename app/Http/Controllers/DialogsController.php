<?php

namespace App\Http\Controllers;

use App\Models\Dialog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DialogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dialogs = Auth::user()->dialogs()
            ->withCount(['messages as unread_count' => function ($q) {
                $q->where('is_readed', false)
                    ->where('user_id', '!=', Auth::id());
            }])
            ->get();

        return view('dialogs.index', compact('dialogs'));
    }

    public function fetchUnreadCount()
    {
        $unread = Auth::user()->dialogs()
            ->withCount(['messages as unread_count' => function ($q) {
                $q->where('is_readed', false)
                    ->where('user_id', '!=', Auth::id());
            }])
            ->get()
            ->pluck('unread_count', 'id');

        return response()->json($unread);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $friends = Auth::user()->friends();
        return view('dialogs.create',compact('friends'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'friends' => 'required|array',
            'friends.*' => 'exists:users,id'
        ]);

        // создаём диалог
        $dialog = Dialog::create([
            'title' => $data['title'],
            'creator_id' => Auth::id(),
        ]);

        // добавляем участников (создатель + выбранные друзья)
        $dialog->users()->attach(array_merge($data['friends'], [Auth::id()]));

        return redirect()->route('dialogs.index', $dialog->id)
            ->with('success', 'Диалог успешно создан!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dialog $dialog)
    {
        $messages = $dialog->messages()->with('user')->orderBy('created_at')->get();

        $dialog->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('is_readed','!=',true)
            ->update(['is_readed' => true]);

        return view('dialogs.show', compact('dialog', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dialog $dialog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dialog $dialog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dialog $dialog)
    {
        //
    }
}
