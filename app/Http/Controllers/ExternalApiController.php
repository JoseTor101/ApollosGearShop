<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

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
