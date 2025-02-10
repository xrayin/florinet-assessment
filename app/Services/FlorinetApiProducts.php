<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;

class FlorinetApiProducts extends FlorinetApiConnection
{

    /**
     * @throws GuzzleException
     */
    public function getAllProducts()
    {
        $currentPage = 1;
        $productsData['data'] = [];
        $tries = 0;
        $lastPage = null;

        do {
            try {
                $response = $this->client->get('products', [
                    'query' => ['page' => $currentPage]
                ]);

                $products = json_decode($response->getBody()->getContents(), true);

                // Merge current page's products into the main array
                $productsData['data'] = array_merge($productsData['data'], $products['data']);

                // Get the last page number from pagination data
                $lastPage = $products['meta']['last_page'] ?? null;

                // Increment page counter
                $currentPage++;

                // Sleep for given seconds to avoid rate limiting
                sleep(env('FLORINET_API_RATE_LIMIT_SLEEP'));

            } catch (\GuzzleHttp\Exception\ClientException $e) {
                if ($e->getResponse()->getStatusCode() === 429 && $tries < env('FLORINET_API_RATE_LIMIT_RETRIES')) {
                    echo "\033[33m⚠ Rate limit hit. Retrying in 5 seconds...\033[0m\n";
                    sleep(5); // Wait for 5 seconds before retrying
                    $tries++;
                } else {
                    throw $e; // Rethrow the exception
                }
            }

        } while (!empty($response) && $response->getStatusCode() === 200 && $lastPage && $currentPage <= $lastPage);

        if(!empty($response)) {
            // Set status and message, in case the status code is not 200, we will know why
            $productsData['status'] = $response->getStatusCode();
            $productsData['message'] = $response->getReasonPhrase();
        }

        return $productsData;

    }

}
