<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{

    public function add($friendId)
    {
        $user=Auth::user();
        if($user->id === $friendId){
            return back()->with('error','попытка добаваить себя в друзья');
        }

        Friend::firstOrCreate([
            'user_id'=>$user->id,
            'friend_id'=>$friendId,
        ]);
        return back()->with('success','заявка отправлена');
    }

    public function accept($friendId)
    {
        $user=Auth::user();

        $friendRequest = Friend::where('user_id',$friendId)
            ->where('friend_id',$user->id)
            ->where('accepted',false)
            ->first();
        if($friendRequest){
            $friendRequest->update(['accepted'=>true]);
            Friend::firstOrCreate([
                'user_id'=>$user->id,
                'friend_id'=>$friendId,
                'accepted'=>true,
            ]);
            return back()->with('success','Вы теперь друзья');
        }
        return back()->with('error','зявка не найдена');

    }

    public function remove($friendId)
    {
        $user = Auth::user();

        Friend::where(function ($query) use ($user, $friendId) {
            $query->where('user_id', $user->id)
                ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($user, $friendId) {
            $query->where('user_id', $friendId)
                ->where('friend_id', $user->id);
        })->delete();

        return back()->with('success', 'Удалено из друзей');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('id', '!=', Auth::id()) // исключаем себя
        ->when($query, function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        })
            ->paginate(10);

        return view('friends.search', compact('users', 'query'));
    }

    public function requests()
    {
        $user = Auth::user();

        $incoming = $user->friendRequestsReceived()->with('user')->get(); // входящие
        $outgoing = $user->friendRequestsSent()->with('friend')->get();   // исходящие

        return view('friends.requests', compact('incoming', 'outgoing'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends();
        return view('friends.index',compact('friends'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Friend $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Friend $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Friend $friend)
    {
        //
    }
}
