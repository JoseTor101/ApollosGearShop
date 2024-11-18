<?php

namespace App\Http\Middleware;

use App\Services\JokeService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as Session_;
use Illuminate\Support\Facades\View;

class InjectJoke
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session_::get('locale', 'en');
        $joke = (new JokeService)->getJoke($locale)['joke'];

        $viewData = [
            'joke' => $joke,
        ];

        View::share('joke', $joke);

        return $next($request);
    }
}
