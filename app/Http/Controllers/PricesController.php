<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    /** 
     * Gets the prices
     * @param Request
     * @return JsonResponse
     */
    public function getPrices(Request $request): JsonResponse {
        $params = $request->validate([
            'product_list' => 'array|required|max:5',
            'product_list.*' => 'string|max:100',
            'account_ref' => 'string|max:100'
        ]);
        $data = Product::getPrice($params['product_list'], $params['account_ref'] ?? null);
        return response()->json([
            'status' => 'ok',
            'data' => $data
        ]);
    }
}
