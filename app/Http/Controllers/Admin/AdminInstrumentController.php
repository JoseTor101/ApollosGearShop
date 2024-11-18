<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

// example created with the Lesson model
// further implementation requires all models

class AdminInstrumentController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function instrument_index(Request $request): View
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

        return view('admin.instrument.index')->with('viewData', $viewData);
    }

    public function instrument_create(): View
    {
        $viewData = [
            'title' => __('navbar.create_instrument'),
            'subtitle' => __('navbar.create_instrument'),
            'categories' => $this->getCategories(),
        ];

        return view('admin.instrument.create')->with('viewData', $viewData);
    }

    public function instrument_save(Request $request): RedirectResponse
    {
        $instrument = new Instrument;
        $imagePath = $this->imageService->store($request);
        Instrument::createInstrument($request->all(), $imagePath);

        $viewData['message'] = __('messages.created');

        return redirect()->route('admin.index')->with('message', $viewData['message']);
    }

    public function instrument_show(string $id, Request $request): View|RedirectResponse
    {
        $instrument = Instrument::with('reviews.user')->findOrFail($id); // Eager load

        $viewData = [
            'title' => $instrument['name'].' - AGS',
            'subtitle' => Str::limit($instrument['name'].' - instrument information', 50),
            'instrument' => $instrument,
            'category' => __('attributes.categories.'.$instrument->getCategory()),
            'reviews' => $instrument->reviews,
        ];

        return view('admin.instrument.show')->with('viewData', $viewData);
    }

    public function instrument_delete(int $id): RedirectResponse
    {
        try {
            $instrument = Instrument::findOrFail($id);
            $instrument->delete();
            $viewData['message'] = __('messages.deleted');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error', __('messages.delete_failed'));
        }

        return redirect()->route('admin.index')->with('message', $viewData['message']);
    }

    // aditional
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
        // $allCategories = Instrument::pluck('category')->unique();

        // return $allCategories->mapWithKeys(function ($category) {
        //     return [$category => __('attributes.categories.' . $category)];
        // });

        $categories = [
            'strings',
            'woodwind',
            'brass',
            'percussion',
            'keyboards_pianos',
            'ethnic_traditional',
            'electronic_dj',
            'accessories',
            'studio_recording',
            'sheet_music_books',
            'bowed_strings',
        ];

        return collect($categories)->mapWithKeys(function ($category) {
            return [$category => __('attributes.categories.'.$category)];
        });
    }
}
