<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'movieOrShowId',
        'body'
    ];

    protected function body(): Attribute
    {
        // Defining a mutator to capitalize first letter of the body
        return Attribute::make(
            set: fn (string $value) => ucfirst($value)
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
