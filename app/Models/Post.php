<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Поля, доступные для массового присвоения.
     */
    protected $fillable = [
        'body',
        'pubtime',
        'images',
        'user_id',
    ];

    /**
     * Преобразования типов.
     */
    protected $casts = [
        'pubtime' => 'datetime',
        'images' => 'array', // хранится как JSON в базе
    ];

    /**
     * Связь: Пост принадлежит пользователю.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
