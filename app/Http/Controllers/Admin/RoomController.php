<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
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

    public function schedule($id)
    {
        // Attempt to find the room by ID and load its schedules and movies
        $room = Room::with('schedules.movie')->find($id);
    
        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }
    
        // Format the response
        return response()->json([
            'name' => $room->name,
            'movies' => $room->schedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id ?? 'N/A',
                    'title' => $schedule->movie->title ?? 'Unknown',
                    'time' => \Carbon\Carbon::parse($schedule->schedule_time)->format('H:i') ?? 'N/A',
                    'price' => $schedule->price ?? 'N/A',
                ];
            }),
        ]);
    }    
}
