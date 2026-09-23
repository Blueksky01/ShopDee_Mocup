<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'reviews'])->where('is_active', true);

        // Search by keyword
        if ($request->filled('search')) {
            $keyword = $request->input('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $products = $query->latest()->paginate(9);
        $categories = Category::all();
        $heroJackets = Product::where('is_active', true)
            ->where(function ($q) {
                $q->where('slug', 'like', '%puffer%')
                  ->orWhere('name', 'like', '%Puffer%');
            })->get()->keyBy(function ($item) {
                if (str_contains(strtolower($item->slug), 'orange') || str_contains(strtolower($item->name), 'orange')) return 'orange';
                if (str_contains(strtolower($item->slug), 'black') || str_contains(strtolower($item->name), 'black')) return 'black';
                if (str_contains(strtolower($item->slug), 'red') || str_contains(strtolower($item->name), 'red')) return 'red';
                return $item->id;
            });

        return view('products.index', compact('products', 'categories', 'heroJackets'));
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'reviews.user']);
        $userReview = auth()->check() ? $product->reviews->firstWhere('user_id', auth()->id()) : null;
        $ratingBreakdown = $product->ratingBreakdown();
        $averageRating = $product->averageRating();
        $reviewsCount = $product->reviewsCount();

        return view('products.show', compact('product', 'userReview', 'ratingBreakdown', 'averageRating', 'reviewsCount'));
    }
}
