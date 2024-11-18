<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Util\OrderUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use InvalidArgumentException;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $viewData = [
            'title' => 'Order - Online Store',
            'subtitle' => __('navbar.list_orders'),
            'orders' => Order::all(),
        ];

        return view('admin.order.index')->with('viewData', $viewData);
    }

    public function checkout(Request $request): RedirectResponse
    {        
        $cartItems = $request->session()->get('cart_items', []);

        if (! OrderUtils::validateSessionItems($cartItems)) {
            return redirect()->back()->withErrors('Invalid cart items format.');
        }

        $validator = Validator::make($request->all(), [
            'cart_items' => 'required|json',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Decode cart items
        $cartItems = json_decode($request->input('cart_items'), true) ?? $cartItems;

        try {
            $result = OrderUtils::processCheckoutItems($cartItems);
            $itemInOrders = $result['itemInOrders'];
            $total = $result['total'];
        } catch (InvalidArgumentException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        if ($total <= 0) {
            return redirect()->back()->withErrors('Invalid total amount.');
        }

        $order = OrderUtils::createOrder($total, $itemInOrders, auth()->id());

        $request->session()->forget('cart_items');

        return redirect()->route('order.index')->with('message', 'Checkout successful! Your order total is $'.number_format($total / 100, 2));
    }

    public function show(int $id): View
    {
        $order = Order::with('itemInOrders')->findOrFail($id);
        $items = $order->getItemInOrder()->get();

        foreach ($items as $item) {
            $item->price = $item->getPrice() * $item->getQuantity();
        }

        $viewData = [
            'title' => 'Order Details',
            'subtitle' => 'Order ID: '.$order->getId(),
            'order' => $order,
            'items' => $items,
        ];

        return view('admin.order.show')->with('viewData', $viewData);
    }

    public function delete(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        OrderUtils::restoreStock($order);

        $order->delete();

        return redirect()->route('admin.index')->with('message', 'Order deleted successfully.');
    }
}
