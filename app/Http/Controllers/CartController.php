<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Util\CartUtility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cartItems = $request->session()->get('cart_items', []);

        $cartProducts = CartUtility::processCartItems($cartItems);

        $viewData = [
            'title' => __('messages.cart'),
            'subtitle' => __('messages.subtitle_cart'),
            'cartProducts' => $cartProducts,
        ];

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(string $id, string $type, Request $request): RedirectResponse
    {
        if (! in_array($type, ['instrument', 'lesson'])) {
            return back()->withErrors('Invalid product type.');
        }
        CartUtility::addItemToCart($id, $type, $request);

        return back();
    }

    public function removeAll(Request $request): RedirectResponse
    {
        $request->session()->forget('cart_items');

        return back();
    }
}
