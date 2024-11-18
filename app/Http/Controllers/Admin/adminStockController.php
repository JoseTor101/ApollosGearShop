<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

// example created with the Lesson model
// further implementation requires all models

class AdminStockController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function stock_index(): View
    {
        $stock = new Stock;
        $latestStocks = $stock->getLatestStocks();

        $viewData = [
            'stocks' => $latestStocks,
            'title' => 'Stock List',
            'subtitle' => __('navbar.stock_entries'),
        ];

        $viewData['message'] = Session::get('message');
        Session::forget('message');

        return view('admin.stock.index')->with('viewData', $viewData);
    }

    public function stock_show(int $id): View
    {
        $stock = Stock::with('instrument')->findOrFail($id); // Eager load

        $viewData = [
            'title' => __('messages.stock_details'),
            'subtitle' => __('navbar.stock_details'),
            'stock' => $stock,
        ];

        return view('admin.stock.show')->with('viewData', $viewData);
    }

    // Stock additional controllers
    public function addStock(Request $request, int $id): RedirectResponse
    {
        $stock = Stock::findOrFail($id);

        $quantity = $request->input('addQuantity');
        $comments = $request->input('addComments');
        $stock->addStock($quantity, $comments);
        $viewData['message'] = 'Stock added successfully!';

        return redirect()->route('admin.index', ['id' => $id])->with('success', $viewData['message']);

    }

    public function lowerStock(Request $request, int $id): RedirectResponse
    {
        $stock = Stock::findOrFail($id);
        $quantity = $request->input('lower_quantity');
        $comments = $request->input('lower_comments');
        $stock->lowerStock($quantity, $comments);
        $viewData['message'] = 'Stock lowered successfully!';

        return redirect()->route('admin.index', ['id' => $id])->with('success', $viewData['message']);

    }
}
