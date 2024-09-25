<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstrumentController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request): View
    {
        $filters = $this->getFilters($request);
        $instruments = Instrument::filterInstruments($filters)->get();

        $viewData = [
            'title' => __('messages.instrument_list'),
            'subtitle' => __('navbar.list_instruments'),
            'message' => Session::get('message'),
            'categories' => $this->getCategories(),
            'instruments' => $instruments,
        ];

        return view('instrument.index')->with('viewData', $viewData);
    }

    protected function getFilters(Request $request): array
    {
        return [
            'searchByName' => $request->input('searchByName'),
            'category' => $request->input('category'),
            'rating' => $request->input('rating'),
            'filterOrder' => $request->input('filterOrder'),
            'filterComment' => $request->input('filterComment'),
        ];
    }

    protected function getCategories(): Collection
    {
        $allCategories = Instrument::pluck('category')->unique();

        return $allCategories->mapWithKeys(function ($category) {
            return [$category => __('attributes.categories.'.$category)];
        });
    }

    public function show(string $id, Request $request): View|RedirectResponse
    {
        $instrument = Instrument::with('reviews.user')->findOrFail($id); // Eager load

        $viewData = [
            'title' => $instrument['name'].' - AGS',
            'subtitle' => Str::limit($instrument['name'].' - instrument information', 50),
            'instrument' => $instrument,
            'category' => __('attributes.categories.'.$instrument->getCategory()),
            'reviews' => $instrument->reviews,
        ];

        return view('instrument.show')->with('viewData', $viewData);
    }
}
