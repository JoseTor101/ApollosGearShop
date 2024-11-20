<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
class GameService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('GAMES_API_URL');
    }

    public function getGames(): array
    {
        $response = Http::get($this->baseUrl);

        if ($response->failed()) {
            throw new Exception('Error fetching products from API');
        }

        return $response->json();
    }
}
