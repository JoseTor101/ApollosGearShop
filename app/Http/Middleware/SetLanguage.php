<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLanguage
{
    public function handle(Request $request, Closure $next)
    {

        $locale = $request->session()->get('locale', 'en');

        App::setLocale($locale);

        return $next($request);
    }
}
