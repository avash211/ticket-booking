<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'show_time_id', 'row', 'column', 'status' ,'email' , 'seat_number' , 'movie_id'
    ];

    public function showTime()
    {
        return $this->belongsTo(ShowTime::class);
    }
}
