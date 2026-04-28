<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function movies()
    {
        return $this->hasMany(Movies::class, 'genre_id');
    }
}
