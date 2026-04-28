<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $fillable = [
        'booking_id',
        'seat_id',
        'code',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

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
