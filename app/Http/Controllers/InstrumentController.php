<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Services\ImageService;
use App\Util\Arrays;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $filters = Arrays::getFilters($request);
        $instruments = Instrument::filterInstruments($filters)->paginate(8);

        $viewData = [
            'title' => __('messages.instrument_list'),
            'subtitle' => __('navbar.list_instruments'),
            'message' => Session::get('message'),
            'categories' => Arrays::getCategories(),
            'instruments' => $instruments,
        ];

        return view('instrument.index')->with('viewData', $viewData);
    }

    public function show(string $id, Request $request): View|RedirectResponse
    {
        $instrument = Instrument::with('reviews.user')->findOrFail($id); // Eager load

        $viewData = [
            'title' => $instrument['name'].' - AGS',
            'subtitle' => Str::limit($instrument['name'].' - instrument information', 50),
            'instrument' => $instrument,
            'category' => __('attributes.categories.'.$instrument->getCategory()),
            'reviews' => $instrument->getReviews(),
        ];

        return view('instrument.show')->with('viewData', $viewData);
    }
}
