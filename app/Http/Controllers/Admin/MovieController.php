<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest; // Form request for validation
use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // List all movies (for admin panel)
    public function index()
    {
        $movies = Movie::paginate(10); // Return 10 movies per page
        return response()->json($movies);
    }

    // Store a new movie
    public function store(MovieRequest $request) // Using MovieRequest for validation
    {
        $movie = Movie::create($request->validated());
        return response()->json($movie, 201); // Return the created movie
    }

    // Show movie details (used for public-facing movie details page)
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('movies.movie-details', compact('movie'));
    }

    // Show movie details for API
    public function apiShow($id)
    {
        $movie = Movie::findOrFail($id);
        return response()->json($movie); // Return JSON for API
    }
    
    // Update a movie
    public function update(MovieRequest $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($request->validated());
        return response()->json($movie); // Return the updated movie
    }

    // Delete a movie
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id); // Ensure the movie exists
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully']);
    }

    // Get schedules for a movie on a specific day
    public function getSchedules(Request $request, $movieId)
    {
        $day = $request->input('day', 'today');
        $date = $day === 'today' ? Carbon::today() : ($day === 'tomorrow' ? Carbon::tomorrow() : Carbon::parse($day));

        $schedules = Schedule::with(['room', 'seats'])
            ->where('movie_id', $movieId)
            ->whereDate('schedule_time', $date)
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'time' => Carbon::parse($schedule->schedule_time)->format('H:i'),
                    'room' => $schedule->room->name ?? 'N/A',
                    'price' => $schedule->seats->isEmpty() ? 'N/A' : $schedule->seats->min('price'),
                ];
            });

        return response()->json(['schedules' => $schedules]);
    }

    // Get rooms by date for a specific movie
    public function getRoomsByDate(Movie $movie, Request $request)
    {
        $date = $request->input('date');
        $formattedDate = Carbon::parse($date)->toDateString();

        $rooms = Room::with(['schedules' => function ($query) use ($movie, $formattedDate) {
            $query->where('movie_id', $movie->id)
                  ->whereDate('schedule_time', $formattedDate);
        }])->get()
            ->map(function ($room) {
                return [
                    'id' => $room->id,
                    'name' => $room->name,
                    'capacity' => $room->capacity,
                    'schedule_time' => $room->schedules->isNotEmpty() ? $room->schedules[0]->schedule_time : 'No schedule available',
                ];
            });

        return response()->json(['rooms' => $rooms]);
    }

    // Render the movies page (Admin Panel)
    public function moviesPage()
    {
        return view('admin.movies.index'); // Render the Blade view
    }
}
