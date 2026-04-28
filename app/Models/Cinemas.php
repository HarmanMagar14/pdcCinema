<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cinemas extends Model
{
    protected $fillable = ['name', 'location'];
    public $timestamps = false;

    public function halls()
    {
        return $this->hasMany(Halls::class, 'cinema_id');
    }
}
