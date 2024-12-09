<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
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
        return response()->json($movie);
    }

    // Update a movie
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

    // Delete a movie
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return response()->json(['message' => 'Movie deleted successfully']);
    }
}
