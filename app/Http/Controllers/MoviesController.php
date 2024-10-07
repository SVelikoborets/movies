<?php

namespace App\Http\Controllers;

use App\Models\Movie;

use App\Models\MovieRating;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MoviesController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::latest();

        if ($request->has('year') && $request->year != '') {
            $query->where('year', $request->year);
        }

        if ($request->has('country') && $request->country != '') {
            $query->where('country', 'like', "%{$request->country}%");
        }

        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', '>=', $request->rating);
        }

        $movies = $query->paginate(12)->appends($request->except('page'));

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
