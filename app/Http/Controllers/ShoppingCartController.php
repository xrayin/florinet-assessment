<?php

namespace App\Http\Controllers;

use App\Services\FlorinetApiOrders;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShoppingCartController extends Controller
{

    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('ShoppingCart');
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function paymentSuccess(Request $request): \Inertia\Response
    {
        return Inertia::render('PaymentSuccess', [
            'orderData' => $request->all()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function calculateTotals(Request $request): \Illuminate\Http\JsonResponse|null
    {

        $data = $request->all();
        $subtotal = 0;
        $shipping = 0;
        $tax = 0;
        $total = 0;

        if (empty($data['selectedProducts'])) {
            return null;
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

    /**
     * @param Request $request
     * @param FlorinetApiOrders $florinetApiOrders
     * @return \Illuminate\Http\JsonResponse|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createOrder(Request $request, FlorinetApiOrders $florinetApiOrders): \Illuminate\Http\JsonResponse|null
    {
        $data = $request->all();

        if (empty($data['selectedProducts'])) {
            session()->flash('error', "No products selected");
            return null;
        }

        return $florinetApiOrders->createOrder($data);
    }

}
