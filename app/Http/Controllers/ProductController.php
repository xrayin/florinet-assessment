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
        $query = Product::query();

        // Apply search filter if 'search' parameter is provided
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort')) {
            $query->orderBy('price', $request->sort);
        }

        return $query->paginate(8); // Consistent pagination size
    }
}
