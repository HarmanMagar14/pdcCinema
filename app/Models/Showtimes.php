<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtimes extends Model
{
    protected $fillable = ['movie_id', 'hall_id', 'start_time', 'end_time', 'price'];
    
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    
    public $timestamps = false;

    public function movie()
    {
        return $this->belongsTo(Movies::class, 'movie_id');
    }

    public function hall()
    {
        return $this->belongsTo(Halls::class, 'hall_id');
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'showtime_id');
    }
}
