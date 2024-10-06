@extends('layouts.app')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            @foreach($movies as $movie)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top img-fluid" src="{{ $movie->poster_url }}" alt="Фото фильма">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-primary btn-block">Подробнее</a>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">{{ $movie->created_at->format('d.m.Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination justify-content-center">
        {{ $movies->links() }}
        </div>
    </div>
@endsection