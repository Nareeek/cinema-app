<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // List all rooms
    public function index()
    {
        return response()->json(Room::all());
    }

    // Store a new room
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $room = Room::create($validated);
        return response()->json($room, 201);
    }

    // Show room details
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return response()->json($room);
    }

    // Update a room
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $room->update($validated);
        return response()->json($room);
    }

    // Delete a room
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }

    public function schedule(Request $request, $roomId)
    {
        $day = $request->input('day', 'today');
        $date = $day === 'today' ? Carbon::today() : ($day === 'tomorrow' ? Carbon::tomorrow() : Carbon::parse($day));
    
        $schedules = Schedule::with('movie')
        ->where('room_id', $roomId)
        ->whereDate('schedule_time', $date)
        ->get()
        ->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'time' => $schedule->schedule_time ? Carbon::parse($schedule->schedule_time)->format('H:i') : 'N/A',
                'title' => $schedule->movie ? $schedule->movie->title : 'N/A',
                'price' => $schedule->price,
            ];
        });
        return response()->json(['movies' => $schedules]);
    }
}
