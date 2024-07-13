<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'title', 'show_date', 'show_time', 'seat_number', 'hall_number', 'validity'
        // Add other fields as needed
    ];

    // Define any relationships or additional methods here
}
