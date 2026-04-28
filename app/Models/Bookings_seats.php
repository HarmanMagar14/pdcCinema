<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bookings;
use App\Models\Seats;

class Bookings_seats extends Model
{
    protected $table = 'booking_seats';
    protected $fillable = ['booking_id', 'seat_id'];
    public $timestamps = false;

    public function booking()
    {
        return $this->belongsTo(Bookings::class, 'booking_id');
    }

    public function seat()
    {
        return $this->belongsTo(Seats::class, 'seat_id');
    }
}
