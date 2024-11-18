<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function setLocale($locale) : RedirectResponse
    {
        session(['locale' => $locale]);

        return redirect()->route('home.index');
    }
}