<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\type;

class JokeService
{
    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = "https://v2.jokeapi.dev/joke/Any";
    }    

    public function getJoke(string $language, int $type = 0) : Array
    {
        $type_ = $type == 0 ? 'single' : 'twopart';
        
        $url = "{$this->baseUrl}?lang={$language}&type={$type_}";

        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception('Error fetching joke');
        }

        return $response->json();
    }

}
