<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ExternalApiController extends Controller
{
    public function index(): View
    {
        return view('externalApi.index');
    }
    
    public function show(string $id, Request $request): View|RedirectResponse
    {
        $viewData = [
            'title' => 'Games - AGS',
            'subtitle' => 'External Api Games',
        ];

        return view('externalApi.show')->with('viewData', $viewData);
    }
}
