<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['row_number', 'seat_number', 'is_booked']; // Include is_booked

    public function bookings()
    {
        return $this->hasOne(Booking::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
