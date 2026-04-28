<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $fillable = ['user_id', 'showtime_id', 'date', 'status'];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function showtime()
    {
        return $this->belongsTo(Showtimes::class, 'showtime_id');
    }

    public function bookings_seats()
    {
        return $this->hasMany(Bookings_seats::class, 'booking_id');
    }

    public function payment()
    {
        return $this->hasOne(Payments::class, 'booking_id');
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'booking_id');
    }
}
