<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Instrument;
use App\Models\Lesson;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {   
        $filters = $this->getFilters($request);
        $instruments = Instrument::filterInstruments($filters)->get();
        $stocks = Stock::all();

        $viewData = [
            'title' => __('messages.admin_title'),
            'subtitle' => __('messages.admin_subtitle'),
            'stocks' => $stocks,
            'orders' => Order::all(),
            'instruments' => $instruments,
            'lessons' => Lesson::all(),
        ];

        return view('admin.dashboard')->with('viewData', $viewData);
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
