<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with('product.category')
            ->latest()
            ->paginate(9);

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product): RedirectResponse
    {
        $user = Auth::user();

        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', "นำ {$product->name} ออกจากรายการสิ่งที่ชอบเรียบร้อยแล้ว");
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return back()->with('success', "เพิ่ม {$product->name} ลงในรายการสิ่งที่ชอบเรียบร้อยแล้ว");
        }
    }
}
