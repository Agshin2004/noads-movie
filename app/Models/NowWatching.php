<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NowWatching extends Model
{
    protected $fillable = [
        'movie_or_show_id',
        'season',
        'episode',
        'left_time',
        'runtime',
        'user_id',
        'media_type'
    ];

    protected function user()
    {
        // foreignKey can be omitted in this case since it follows convention in NowWatching table (model_column)
        // but if it was something like userId the we would have to add it
        return $this->belongsTo(User::class, 'user_id');
    }
}
