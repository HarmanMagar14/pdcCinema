<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halls extends Model
{
    protected $fillable = [
        'cinema_id', 
        'name', 
        'capacity', 
        'screen_type', 
        'audio_system', 
        'screen_dimensions', 
        'projection_type', 
        'seat_layout_config'
    ];

    protected $casts = [
        'seat_layout_config' => 'array',
    ];
    public $timestamps = false;

    public function cinema()
    {
        return $this->belongsTo(Cinemas::class, 'cinema_id');
    }

    public function showtimes()
    {
        return $this->hasMany(Showtimes::class, 'hall_id');
    }

    public function seats()
    {
        return $this->hasMany(Seats::class, 'hall_id');
    }
}
