<?php

namespace Tests\Unit;

use App\Services\JokeService;
use Tests\TestCase;

class JokeServiceTest extends TestCase
{
    public function test_get_joke_returns_data_from_api()
    {
        $jokeService = new JokeService;
        $response = $jokeService->getJoke('es');
        //$response = $jokeService->getJoke('en');

        $this->assertIsArray($response);
        $this->assertArrayHasKey('joke', $response);
        $this->assertArrayHasKey('category', $response);
        $this->assertArrayHasKey('lang', $response);

        //$this->assertEquals('Programming', $response['category']);
        $this->assertEquals('es', $response['lang']);
    }
}
