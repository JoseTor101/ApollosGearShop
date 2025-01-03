<?php

namespace App\Http\Controllers;

use App\Services\GameService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ExternalApiController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index(Request $request): View
    {
        try {
            $response = Http::get(env('GAMES_API_URL'));

            if ($response->successful()) {
                $games = $response->json();

                if (empty($games)) {
                    $error = 'No games found.';

                    return view('externalApi.index', compact('error'));
                }

                $viewData = [
                    'title' => 'Games - AGS',
                    'subtitle' => 'External Api Games',
                    'games' => $games,
                ];

                return view('externalApi.index', compact('viewData'));
            } else {
                throw new Exception('Error fetching data from API');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();

            return view('externalApi.index', compact('error'));
        }
    }

    public function show(string $id, Request $request): View|RedirectResponse
    {
        $viewData = [
            'title' => 'Games - AGS',
            'subtitle' => 'External Api Games',
        ];

        try {
            $games = $this->gameService->getGames();

            $game = collect($games)->firstWhere('id', $id);
          
            if (! $game) {

                $viewData['error'] = 'Game not found.';
            } else {
                $viewData['game'] = $game;
            }
        } catch (Exception $e) {
            return redirect()->route('externalApi.index')->with('error', 'Failed to fetch games.');
        }

        return view('externalApi.show', compact('viewData'));
    }
}
