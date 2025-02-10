<?php

namespace Database\Seeders;

use App\Services\FlorinetApiProducts;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws GuzzleException
     */
    public function run(): void
    {
        $floriNetApiProducts = new FlorinetApiProducts();
        $productsData = $floriNetApiProducts->getAllProducts();

        foreach ($productsData['data'] as $product) {
            \App\Models\Product::updateOrCreate([
                'article_code' => $product['article_code'],
                ],[
                'title' => $product['title'],
                'description' => $product['description'],
                'price' => $product['price'],
                'selling_price' => $product['selling_price'],
                'currency' => $product['currency'],
                'image_url' => $product['image_url'],
                'stock' => $product['stock'],
                'properties' => json_encode($product['properties']),
                'published_at' => $product['published_at'],
            ]);
        }

        $message = $productsData['status'] === 200
            ? "\033[32m✔ Status: {$productsData['status']}\n  Message: Products seeded successfully\033[0m"
            : "\033[31m✖ Status: {$productsData['status']}\n  Message: Products failed to seed.\n   Reason: {$productsData['message']}\033[0m";

        echo PHP_EOL . $message . PHP_EOL;
    }
}
