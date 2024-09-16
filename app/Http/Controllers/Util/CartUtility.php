<?php

namespace App\Http\Controllers\Util;

use App\Models\Instrument;
use App\Models\Lesson;
use Illuminate\Http\Request;

class CartUtility
{
    public static function addItemToCart(string $id, string $type, Request $request, int $quantity): void
    {
        $cartItems = $request->session()->get('cart_items', []);

        $cartItems[] = ['id' => $id, 'type' => $type, 'quantity' => $quantity];

        $request->session()->put('cart_items', $cartItems);
    }

    public static function processCartItems(array $cartItems): array
    {
        $cartProducts = [];

        foreach ($cartItems as $item) {
            if ($item['type'] === 'instrument') {
                $product = Instrument::find($item['id']);
                if ($product) {
                    $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
                    $cartProducts[] = [
                        'type' => 'Instrument',
                        'product' => $product,
                        'quantity' => $quantity,
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

        return $cartProducts;
    }
}
