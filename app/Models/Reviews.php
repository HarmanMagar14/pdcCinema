<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Movies;
use App\Models\User;

class Reviews extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'rating',
        'comment',
    ];

    public function movie()
    {
        return $this->belongsTo(Movies::class, 'movie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
