<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'booking_id', 
        'amount', 
        'method', 
        'status', 
        'date',
        'paymongo_payment_id',
        'paymongo_session_id',
        'payment_method_type',
        'receipt_number',
    ];
    
    protected $casts = [
        'date' => 'datetime',
    ];
    
    public $timestamps = false;

    public function booking()
    {
        return $this->belongsTo(Bookings::class);
    }
}
