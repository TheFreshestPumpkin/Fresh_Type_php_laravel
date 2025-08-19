<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    // Связь: диалог содержит много пользователей
    public function users()
    {
        return $this->belongsToMany(User::class, 'dialog_user');
    }

    // Связь: у диалога есть сообщения
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
