<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\People;

class MovieApiService
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.kinopoisk.api_url') ?? throw new \InvalidArgumentException("API URL not configured");
        $this->apiKey = config('services.kinopoisk.api_key') ?? throw new \InvalidArgumentException("API Key not configured");
    }

    public function fetchAdventureMovies()
    {
        for($page=1; $page<=5; $page++) {
            $response = Http::withHeaders([
                'X-API-KEY' => $this->apiKey,
            ])->get($this->apiUrl . '/api/v2.2/films', [
                'genres' => 7,
                'type' => 'FILM',
                'page' => $page,
                'limit' => 100,
            ]);

            $films = $response->json()['items'];
            $filmIds = [];

            foreach ($films as $film) {
                $filmIds[] = $film['kinopoiskId'];
            }

            foreach ($filmIds as $filmId) {
                $this->fetchAndSaveMovieDetails($filmId);
            }
        }
    }

    private function fetchAndSaveMovieDetails($filmId)
    {
        $movieResponse = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->get($this->apiUrl . "/api/v2.2/films/{$filmId}");

        $movieData = $movieResponse->json();

        $movie = Movie::updateOrCreate([
            'kinopoisk_id' => $movieData['kinopoiskId'],
        ], [
            'title' => $movieData['nameRu'] ?? $movieData['nameEn'] ?? 'Фильм',
            'poster_url' => $movieData['posterUrl'],
            'year' => $movieData['year'] ?? 'Нет данных',
            'country' => $movieData['countries'][0]['country'] ?? 'Нет данных',
            'description' => $movieData['description'] ?? 'Нет данных',
            'rating' => $movieData['ratingKinopoisk'],
            'external_link' => $movieData['webUrl'] ?? 'https://www.kinopoisk.ru',
        ]);

        $this->fetchAndSaveStaff($movie, $filmId);
    }

    private function fetchAndSaveStaff(Movie $movie, $filmId)
    {
        $staffResponse = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->get($this->apiUrl . "/api/v1/staff", [
            'filmId' => $filmId,
        ]);

        $staffData = $staffResponse->json();

        foreach ($staffData as $person) {

            if (in_array($person['professionKey'], ['DIRECTOR', 'ACTOR'])) {
                People::updateOrCreate([
                    'staff_id' => $person['staffId'],
                    'movie_id' => $movie->id,
                ], [
                    'name' => trim($person['nameRu']) !== '' ? $person['nameRu'] : ($person['nameEn'] ?? 'Noname'),
                    'profession' => $person['professionKey'],
                    'poster_url' => $person['posterUrl'],
                ]);
            }
        }
    }
}