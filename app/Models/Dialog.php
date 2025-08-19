<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'dialog_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
