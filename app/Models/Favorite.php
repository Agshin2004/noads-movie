<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'movieOrShowId',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
