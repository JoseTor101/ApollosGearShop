<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\Stock;
use App\Util\Arrays;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $filters = Arrays::getFilters($request);
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
}
