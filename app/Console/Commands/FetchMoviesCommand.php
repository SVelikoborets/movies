<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MovieApiService;

class FetchMoviesCommand extends Command
{
    protected $signature = 'movies:fetch';
    protected $description = 'Fetch adventure movies from Kinopoisk API Unofficial';

    public function handle(MovieApiService $movieService)
    {
        $this->info('Starting to fetch adventure movies...');
        $movieService->fetchAdventureMovies();
        $this->info('Finished fetching adventure movies.');
    }
}