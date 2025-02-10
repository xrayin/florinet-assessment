<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Shop');
    }

    public function getProducts(Request $request)
    {
        return Product::Paginate(8);
    }

    public function searchProducts(Request $request)
    {
        $products = Product::query();

        if ($request->has('search')) {
            $products->where('title', 'like', '%' . $request->search . '%');
        }

        return $products->paginate(10);
    }

    public function sortProducts(Request $request)
    {
        $products = Product::query();

        if ($request->has('sort')) {
            $products->orderBy('price', $request->sort);
        }

        return $products->paginate(10);
    }
}
