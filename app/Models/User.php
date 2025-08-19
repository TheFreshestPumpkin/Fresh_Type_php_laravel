<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }
    public function dialogs()
    {
        return $this->belongsToMany(Dialog::class, 'dialog_user');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function friendsOfMine()
    {
        return $this->hasMany(Friend::class, 'user_id');
    }

    public function friendsOf()
    {
        return $this->hasMany(Friend::class, 'friend_id');
    }

    public function friends()
    {
        $friendsOfMine = $this->friendsOfMine()
            ->where('accepted', true)
            ->with('friend')
            ->get()
            ->pluck('friend');

        $friendsOf = $this->friendsOf()
            ->where('accepted', true)
            ->with('user')
            ->get()
            ->pluck('user');

        return $friendsOfMine
            ->merge($friendsOf)
            ->unique('id')
            ->values();
    }

    public function isFriendWith($userId)
    {
        return $this->friends()->contains('id', $userId);
    }

    public function friendRequestsSent()
    {
        return $this->hasMany(Friend::class, 'user_id')
            ->where('accepted', false);
    }

    public function friendRequestsReceived()
    {
        return $this->hasMany(Friend::class, 'friend_id')
            ->where('accepted', false);
    }

}
