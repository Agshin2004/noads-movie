<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'movieOrShowId',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
