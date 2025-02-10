<?php

namespace App\Services;

class FlorinetApiConnection
{
    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => env('FLORINET_API_BASE_URL'),
            'headers' => [
                'Authorization' => 'Bearer ' . env('FLORINET_API_TOKEN'),
            ],
        ]);
    }



}
