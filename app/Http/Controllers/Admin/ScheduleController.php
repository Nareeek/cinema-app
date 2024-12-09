<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Fetch all schedules
    public function index()
    {
        return response()->json(Schedule::with(['room', 'movie'])->get());
    }

    // Create a new schedule
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'movie_id' => 'required|exists:movies,id',
            'schedule_time' => 'required|date|after:now',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        // Check for overlapping schedules in the same room
        $overlap = Schedule::where('room_id', $request->room_id)
            ->where('schedule_time', $request->schedule_time)
            ->exists();

        if ($overlap) {
            return response()->json(['error' => 'Schedule conflicts with another movie in the same room.'], 422);
        }

        // Check if the movie is already scheduled at the same time in another room
        $movieOverlap = Schedule::where('movie_id', $request->movie_id)
            ->where('schedule_time', $request->schedule_time)
            ->exists();

        if ($movieOverlap) {
            return response()->json(['error' => 'This movie is already scheduled at the same time in another room.'], 422);
        }

        $schedule = Schedule::create($validated);
        return response()->json($schedule, 201);
    }

    // Get details of a specific schedule
    public function show($id)
    {
        $schedule = Schedule::with(['room', 'movie'])->findOrFail($id);
        return response()->json($schedule);
    }

    // Update schedule details
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'room_id' => 'sometimes|exists:rooms,id',
            'movie_id' => 'sometimes|exists:movies,id',
            'schedule_time' => 'sometimes|date|after:now',
            'price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|in:Active,Inactive',
        ]);

        // Check for overlapping schedules in the same room
        $overlap = Schedule::where('room_id', $request->room_id)
            ->where('schedule_time', $request->schedule_time)
            ->where('id', '!=', $id)
            ->exists();

        if ($overlap) {
            return response()->json(['error' => 'Schedule conflicts with another movie in the same room.'], 422);
        }

        // Check if the movie is already scheduled at the same time in another room
        $movieOverlap = Schedule::where('movie_id', $request->movie_id)
            ->where('schedule_time', $request->schedule_time)
            ->where('id', '!=', $id)
            ->exists();

        if ($movieOverlap) {
            return response()->json(['error' => 'This movie is already scheduled at the same time in another room.'], 422);
        }

        $schedule->update($validated);
        return response()->json($schedule);
    }

    // Delete a schedule
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
