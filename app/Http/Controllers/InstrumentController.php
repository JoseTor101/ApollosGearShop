<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Util\CartUtility;
use App\Models\Instrument;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
        $filters = [
            'searchByName' => $request->input('searchByName'),
            'category' => $request->input('category'),
            'rating' => $request->input('rating'),
            'filterOrder' => $request->input('filterOrder'),
        ];

        $instruments = Instrument::filterInstruments($filters)->get();
        $allCategories = Instrument::pluck('category')->unique();

        $categories = $allCategories->mapWithKeys(function ($category) {
            return [$category => __('attributes.categories.'.$category)];
        });

        $viewData = [
            'title' => __('messages.instrument_list'),
            'subtitle' => __('navbar.list_instruments'),
            'message' => Session::get('message'),
            'categories' => $categories,
            'instruments' => $instruments,
        ];

        return view('instrument.index')->with('viewData', $viewData);
    }

    public function show(string $id): View|RedirectResponse
    {
        $viewData = [];
        $instrument = Instrument::findOrfail($id);
        $instrument = Instrument::with('reviews.user')->findOrFail($id);
        $viewData = [
            'title' => $instrument['name'].' - AGS',
            'subtitle' => Str::limit($instrument['name'].' - instrument information', 50),
            'instrument' => $instrument,
            'category' => __('attributes.categories.'.$instrument->getCategory()),
            'reviews' => $instrument->reviews,
        ];

        return view('instrument.show')->with('viewData', $viewData);
    }

    public function addToCart(Request $request, string $id): RedirectResponse
    {
        $instrument = Instrument::findOrFail($id);

        $quantity = $request->input('quantity', 1);

        if ($quantity > $instrument->getQuantity()) {
            return redirect()->back()->withErrors(['quantity' => 'The requested quantity exceeds the available stock.']);
        }

        CartUtility::addItemToCart($id, 'instrument', $request, $quantity);

        return redirect()->route('cart.index')->with('message', 'Instrument added to cart!');
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('navbar.create_instrument');
        $viewData['subtitle'] = __('navbar.create_instrument');

        return view('instrument.create')->with('viewData', $viewData);
    }

    public function save(Request $request): RedirectResponse
    {
        $instrument = new Instrument;

        try {
            $instrument->validate($request->all());
            $imagePath = $this->imageService->store($request);
            $instrument = Instrument::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'category' => $request->input('category'),
                'brand' => $request->input('brand'),
                'price' => $request->input('price'),
                'reviewSum' => $request->input('reviewSum', 0),
                'numberOfReviews' => $request->input('numberOfReviews', 0),
                'image' => $imagePath,
            ]);

            $instrument->stocks()->create([
                'quantity' => $request->input('stock'),
                'type' => 'added',
                'comments' => 'Initial stock',
            ]);

            $message = __('messages.created');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('instrument.index')->with('message', $message);
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $instrument = Instrument::findOrFail($id);
            $instrument->delete();
            $viewData['message'] = __('messages.deleted');
        } catch (\Exception $e) {
            return redirect()->route('instrument.index')->with('error', __('messages.delete_failed'));
        }

        return redirect()->route('instrument.index')->with('message', $viewData['message']);
    }
}
