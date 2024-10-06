<?php

namespace App\Http\Controllers;

use App\Models\Movie;

use App\Models\MovieRating;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MoviesController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->paginate(12);
        return view('movie.index', compact('movies'));
    }
    public function show($id)
    {
        $movie = Movie::with('people', 'comments','ratings')->findOrFail($id);
        $rating = $movie->averageRating();
        return view('movie.show', compact('movie','rating'));
    }
    public function rate(Request $request, Movie $movie)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:10',
        ]);

        $rating = new MovieRating([
            'user_id' => auth()->id(),
            'movie_id' => $movie->id,
            'rating' => $request->rating,
        ]);

        $rating->save();
        return back()->with('success', 'Рейтинг успешно добавлен');
    }
}
