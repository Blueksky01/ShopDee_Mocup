<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'กรุณาเลือกคะแนนดาว',
            'rating.min' => 'คะแนนดาวต้องอยู่อย่างน้อย 1 ดาว',
            'rating.max' => 'คะแนนดาวไม่เกิน 5 ดาว',
            'comment.max' => 'ความคิดเห็นต้องไม่เกิน 1,000 ตัวอักษร',
        ]);

        Review::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]
        );

        return back()->with('success', 'ขอบคุณสำหรับรีวิวและความคิดเห็นของคุณ!');
    }

    public function destroy(Review $review): RedirectResponse
    {
        if (auth()->id() !== $review->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'คุณไม่มีสิทธิ์ในการลบรีวิวนี้');
        }

        $review->delete();

        return back()->with('success', 'ลบรีวิวเรียบร้อยแล้ว');
    }
}
