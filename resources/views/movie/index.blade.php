@extends('layouts.app')
@section('title','КиноКлад')
@section('content')

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="filter-section mb-4 col-12">
                <form action="{{ route('movies.index') }}" method="GET">
                    <div class="form-row d-flex">
                        <div class="col">
                            <select name="year" id="year" class="custom-select @error('year') is-invalid @enderror">
                                <option value="">Год</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mx-3">
                            <select name="country" id="country" class="custom-select @error('country') is-invalid @enderror">
                                <option value="">Страна</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mx-2">
                            <select name="rating" id="rating" class="custom-select @error('rating') is-invalid @enderror">
                                <option value="">Рейтинг от:</option>
                                @for ($i = 1; $i < 10; $i++)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col ml-2">
                            <button type="submit" class="btn btn-gradient w-100"><i class="fas fa-search"></i> Найти </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="movies-section col-12">
                <div class="row">
                    @foreach($movies as $movie)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <a href="{{ route('movies.show', $movie->id) }}" >
                                    <img class="card-img-top img-fluid" src="{{ $movie->poster_url }}" alt="Фото фильма">
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <a href="{{ route('movies.show', $movie->id) }}" >
                                        <h5 class="card-title">{{ $movie->title }} </h5>
                                    </a>
                                    <small class="text-muted"><i class="fas fa-star"></i>
                                        {{ $movie->rating }}
                                    </small>
                                    <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-movie btn-block">
                                            Подробнее
                                        </a>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <small class="text-muted "><i class="fas fa-calendar-alt"></i>
                                        {{ $movie->year }}
                                    </small>
                                    <small class="text-muted ml-3"><i class="fas fa-globe-americas"></i>
                                        {{ $movie->country }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="pagination justify-content-center">
            {{ $movies->links() }}
        </div>
    </div>
@endsection