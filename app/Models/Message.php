<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    protected $fillable = [
        'body',
        'user_id',
        'post_id',
    ];

    protected $casts = [
        'is_readed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dialog()
    {
        return $this->belongsTo(Dialog::class);
    }

}
