<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function likes()
    {
        return $this->hasMany(Like::class, 'comment_id', 'comment_id');
    }

    protected $fillable = [
        'user_id', 'message',
    ];
}
