<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    // List all movies
    public function index()
    {
        $movies = Movie::all();
        return response()->json($movies);
    }

    // Show details for a specific movie
    public function show($id)
    {
        $movie = Movie::with('schedules.room')->findOrFail($id);
        return response()->json($movie);
    }
}
