<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    // List all rooms
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }

    // Get schedules for a specific room
    public function schedules($id)
    {
        $room = Room::with('schedules.movie')->findOrFail($id);
        return response()->json($room->schedules);
    }
}
