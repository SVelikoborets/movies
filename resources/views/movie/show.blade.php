@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ $movie->poster_url }}" alt="Постер фильма" class="img-fluid" style="height: 400px; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <h2>{{ $movie->title }}</h2>
                <p><strong>Год выпуска:</strong> {{ $movie->year }}</p>
                <p><strong>Рейтинг КиноПоиска:</strong> {{ $movie->rating }}</p>
                <p><strong>Рейтинг:</strong> {{ $rating ? number_format($rating, 1) . ' / 10' : 'Нет рейтинга' }}</p>

                <p><strong>Режиссер:</strong>
                    @foreach($movie->people->where('profession', 'DIRECTOR') as $director)
                        {{ $director->name }}.
                    @endforeach
                </p>

                <p><strong>Актерский состав:</strong>
                    @foreach($movie->people->where('profession', 'ACTOR')->take(6) as $actor)
                        {{ $actor->name }},
                    @endforeach
                    @if($movie->people->where('profession', 'ACTOR')->count() > 6)
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseActors" aria-expanded="false" aria-controls="collapseActors">
                            Показать всех актеров
                        </button>
                    @endif
                </p>

                <div class="collapse" id="collapseActors">
                    @foreach($movie->people->where('profession', 'ACTOR')->skip(6) as $actor)
                        {{ $actor->name }},
                    @endforeach
                </div>

                <p><strong>Описание:</strong></p>
                <p>{{ $movie->description }}</p>
                <a href="{{ $movie->external_link }}" target="_blank" class="btn btn-primary">Смотреть на Кинопоиске</a>

                <hr>

                @auth
                <div class="mt-4">
                    <h5>Оцените фильм:</h5>
                    <form action="{{ route('movies.rate', $movie->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="number" name="rating" class="form-control" placeholder="Введите рейтинг от 1 до 10" min="1" max="10" required>
                        </div>
                        <button type="submit" class="btn btn-success">Добавить рейтинг</button>
                    </form>
                </div>
                @endauth

                <hr>
                <div class="mt-4">
                    <h5>Комментарии:</h5>
                    <div class="mb-3">
                        @foreach($movie->comments as $comment)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <p class="card-text">{{ $comment->comment }}</p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            {{ $comment->user->name }} | {{ $comment->created_at->format('d.m.Y H:i') }}
                                        </small>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @auth
                    <form action="{{ route('comments.store', $movie->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="text" class="form-control" rows="3" placeholder="Добавьте ваш комментарий" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                    @endauth

                    @guest
                    <div class="mt-4">
                        <h5>Чтобы добавить комментарий
                            <a class="blue-link" href="{{ route('login') }}">авторизуйтесь</a>.
                        </h5>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
@endsection