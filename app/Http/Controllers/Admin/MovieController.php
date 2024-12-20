<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest; // Form request for validation
use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    // List all movies (for admin panel)
    public function index()
    {
        $movies = Movie::paginate(10); // Return 10 movies per page
        return response()->json($movies);
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

    // Store a new movie
    public function store(MovieRequest $request)
    {
        $data = $request->validated();
    
        if ($request->hasFile('poster_file')) {
            $data['poster_url'] = $this->handlePosterFile($request->file('poster_file'));
        } elseif ($request->input('poster_url')) {
            try {
                $data['poster_url'] = $this->downloadAndSaveImage($request->input('poster_url'));
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to save poster file.', 'error' => $e->getMessage()], 500);
            }
        }
    
        try {
            $movie = Movie::create($data);
            return response()->json(['message' => 'Movie created successfully!', 'movie' => $movie], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create movie.', 'error' => $e->getMessage()], 500);
        }
    }


    // Update an existing movie
    public function update(MovieRequest $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $data = $request->validated();

        // Handle poster file upload
        if ($request->hasFile('poster_file')) {
            try {
                $data['poster_url'] = $this->handlePosterFile($request->file('poster_file'));
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Failed to save poster file.',
                    'error' => $e->getMessage()
                ], 500);
            }
        } elseif ($request->input('poster_url')) {
            try {
                $data['poster_url'] = $this->handlePosterUrl($request->input('poster_url'));
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Failed to download image.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        $movie->update($data);

        return response()->json([
            'message' => 'Movie updated successfully!',
            'movie' => $movie
        ], 200);
    }

    // Delete a movie
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully']);
    }

    // Handle file upload and move the file to the storage folder
    private function handlePosterFile($file)
    {
        $destinationPath = storage_path('app/public/posters'); // Ensure this folder exists
        $fileName = uniqid() . '_' . $file->getClientOriginalName();

        try {
            $file->move($destinationPath, $fileName); // Move the file
            return '/storage/posters/' . $fileName; // Return the public URL path
        } catch (\Exception $e) {
            \Log::error('Error moving poster file:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to move poster file.');
        }
    }

    // Handle image URL download
    private function handlePosterUrl($posterUrl)
    {
        try {
            return $this->downloadAndSaveImage($posterUrl);
        } catch (\Exception $e) {
            \Log::error('Error downloading poster from URL:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to download poster image.');
        }
    }


    private function isValidImageUrl($url)
    {
        try {
            $headers = get_headers($url, 1); // Fetch headers for the URL
            return strpos($headers[0], '200 OK') !== false && 
                isset($headers['Content-Type']) && 
                strpos($headers['Content-Type'], 'image/') !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    // Download and save the image from a URL
    private function downloadAndSaveImage($url)
    {
        $destinationPath = storage_path('app/public/posters');
        $fileName = uniqid() . '.jpg';
    
        $maxAttempts = 3;
        $attempt = 0;
    
        while ($attempt < $maxAttempts) {
            try {
                $response = Http::get($url);
                if ($response->successful()) {
                    file_put_contents($destinationPath . '/' . $fileName, $response->body());
                    return '/storage/posters/' . $fileName;
                } else {
                    $attempt++;
                    sleep(2); // Wait for 2 seconds before retrying
                }
            } catch (\Exception $e) {
                $attempt++;
                if ($attempt >= $maxAttempts) {
                    \Log::error('Error saving downloaded image after retries:', ['error' => $e->getMessage()]);
                    throw $e;
                }
            }
        }
    
        throw new \Exception('Failed to download image after multiple attempts.');
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
