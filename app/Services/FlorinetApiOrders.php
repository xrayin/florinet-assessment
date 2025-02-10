<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class FlorinetApiOrders extends FlorinetApiConnection
{

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     * @throws GuzzleException
     */
    public function createOrder(array $data): \Illuminate\Http\JsonResponse
    {
        // Prepare request data from incoming request
        $bodyData = [
            'customer_name' => 'Test Name',
            'customer_email' => 'test@email.nl',
            'customer_street_name' => 'Test Street',
            'customer_house_number' => '1',
            'customer_postal_code' => '1234AB',
            'customer_city' => 'Test City',
            'customer_phone_number' => '0612345678',
            'note' => 'Test Note',
            'order_rows' => []
        ];

        foreach ($data['selectedProducts'] as $product) {
            $bodyData['order_rows'][] = [
                'product_id' => $product['id'],
                'amount' => $product['quantity']
            ];
        }

        try {
            $response = $this->client->post('orders', [
                'json' => $bodyData
            ]);

            $orderData = json_decode($response->getBody()->getContents(), true);

            return response()->json([
                'status' => $response->getStatusCode(),
                'message' => $response->getReasonPhrase(),
                'data' => $orderData
            ], $response->getStatusCode());

        } catch (\Exception $e) {

            return response()->json([
                'status' => $e->getCode(),
                'message' => "Failed to create order, please contact customer service at 1234567890",
            ], $e->getCode());
        }
    }

}
