<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        // Obtener los instrumentos y lecciones del carrito
        $cartItems = $request->session()->get('cart_items', []);

        $cartProducts = [];
        foreach ($cartItems as $item) {
            if ($item['type'] === 'instrument') {
                $product = Instrument::find($item['id']);
                if ($product) {
                    // Obtener la cantidad en stock del producto
                    $stockQuantity = $product->getQuantity();
                    $cartProducts[] = [
                        'type' => 'Instrument',
                        'product' => $product,
                        'quantity' => $item['quantity'], // Usa la cantidad almacenada en el carrito
                    ];
                }
            } elseif ($item['type'] === 'lesson') {
                $product = Lesson::find($item['id']);
                if ($product) {
                    $cartProducts[] = [
                        'type' => 'Lesson',
                        'product' => $product,
                    ];
                }
            }
        }

        $viewData = [];
        $viewData['title'] = 'Cart - Online Store';
        $viewData['subtitle'] = 'Shopping Cart';
        $viewData['cartProducts'] = $cartProducts;

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(string $id, string $type, Request $request): RedirectResponse
    {
        // Validar que el tipo sea válido
        if (! in_array($type, ['instrument', 'lesson'])) {
            return back()->withErrors('Invalid product type.');
        }

        // Agregar el producto al carrito
        $cartItems = $request->session()->get('cart_items', []);
        $cartItems[] = ['id' => $id, 'type' => $type];
        $request->session()->put('cart_items', $cartItems);

        return back();
    }

    public function removeAll(Request $request): RedirectResponse
    {
        $request->session()->forget('cart_items');

        return back();
    }
}