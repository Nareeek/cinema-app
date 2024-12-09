<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // List all schedules
    public function index()
    {
        return response()->json(Schedule::with(['movie', 'room'])->get());
    }

    // Store a new schedule
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'movie_id' => 'required|exists:movies,id',
            'schedule_time' => 'required|date',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        $schedule = Schedule::create($validated);
        return response()->json($schedule, 201);
    }

    // Show schedule details
    public function show($id)
    {
        $schedule = Schedule::with(['movie', 'room'])->findOrFail($id);
        return response()->json($schedule);
    }

    // Update a schedule
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'movie_id' => 'required|exists:movies,id',
            'schedule_time' => 'required|date',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|in:Active,Inactive',
        ]);

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
