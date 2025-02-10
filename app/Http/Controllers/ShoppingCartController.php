<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ShoppingCartController extends Controller
{
    public function index()
    {
        return Inertia::render('ShoppingCart');
    }

    public function calculateTotals(Request $request)
    {

        $data = $request->all();
        $subtotal = 0;
        $shipping = 0;
        $tax = 0;
        $total = 0;

        if (empty($data['selectedProducts'])) {
            return;
        }

        foreach ($data['selectedProducts'] as $product) {
            $subtotal += floatval($product['price']) * (int)$product['quantity'];
        }

        $shipping = $subtotal > 100 ? 0 : 10;

        $tax = $subtotal * 0.21;

        $total = $subtotal + $shipping + $tax;

        return response()->json([
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
        ]);
    }

}
