<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MovieApiService;

class FetchMoviesCommand extends Command
{
    protected $signature = 'movies:fetch';
    protected $description = 'Fetch adventure movies from Kinopoisk API';

    public function handle(MovieApiService $movieService)
    {
        $this->info('Starting to fetch adventure movies...');
        $movieService->fetchAdventureMovies();
        //$movieService->fetchAdventureStaff();
        $this->info('Finished fetching adventure movies.');
    }
}