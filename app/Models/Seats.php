<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    protected $fillable = ['hall_id', 'number', 'row_number'];
    public $timestamps = false;
}
