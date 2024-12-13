<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = ['row_number', 'seat_number', 'room_id', 'is_booked']; // Include is_booked


    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bookings()
    {
        return $this->hasOne(Booking::class);
    }
}
