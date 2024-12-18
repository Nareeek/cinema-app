<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // List all movies
    public function index()
    {
        return response()->json(Movie::all());
    }

    // Store a new movie
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_url' => 'required|url',
            'trailer_url' => 'nullable|url',
            'duration' => 'required|integer|min:1',
        ]);

        $movie = Movie::create($validated);
        return response()->json($movie, 201);
    }

    // Show movie details
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movies.movie-details', compact('movie'));
    }

    public function getSchedules(Request $request, $movieId)
    {
        $day = $request->input('day', 'today');
        $date = $day === 'today' ? Carbon::today() : ($day === 'tomorrow' ? Carbon::tomorrow() : Carbon::parse($day));
    
        $schedules = Schedule::with(['room', 'seats'])
            ->where('movie_id', $movieId)
            ->whereDate('schedule_time', $date)
            ->get()
            ->map(function ($schedule) {
                // Calculate the average or minimum seat price for the schedule
                $price = $schedule->seats->isEmpty()
                    ? 'N/A'
                    : $schedule->seats->min('price'); // You can use 'min', 'max', or 'avg' as needed
    
                return [
                    'id' => $schedule->id,
                    'time' => Carbon::parse($schedule->schedule_time)->format('H:i'),
                    'room' => $schedule->room->name ?? 'N/A',
                    'price' => $price,
                ];
            });
        
        return response()->json(['schedules' => $schedules]);
    }    

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_url' => 'required|url',
            'trailer_url' => 'nullable|url',
            'duration' => 'required|integer|min:1',
        ]);

        $movie->update($validated);
        return response()->json($movie);
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully']);
    }

    public function getRoomsByDate(Movie $movie, Request $request)
    {
        $date = $request->input('date');
        $formattedDate = Carbon::parse($date)->toDateString();
        // \Log::info("Fetching rooms for movie ID {$movie->id} on date {$formattedDate}");
    
        $rooms = Room::with(['schedules' => function ($query) use ($movie, $formattedDate) {
            $query->where('movie_id', $movie->id)
                  ->whereDate('schedule_time', $formattedDate);
        }])->get()->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'capacity' => $room->capacity,
                'schedule_time' => $room->schedules->isNotEmpty() ? $room->schedules[0]->schedule_time : 'No schedule available',
            ];
        });
        return response()->json(['rooms' => $rooms]);
    }    
    
}
