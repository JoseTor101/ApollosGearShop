<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Instrument;
use Illuminate\Http\JsonResponse;

class ProductApiControllerV2 extends Controller
{
    public function index(): JsonResponse
    {
        $products = ProductResource::collection(Instrument::all());
        return response()->json($products, 200);
    }

    public function show(string $id): JsonResponse
    {   
        $product = new ProductResource(Instrument::findOrFail($id));
        return response()->json($product, 200);
    }

}