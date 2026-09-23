<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'sold_count',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'sold_count' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function totalSold(): int
    {
        $orderSold = (int) $this->orderItems()
            ->whereHas('order', function ($query) {
                $query->whereIn('status', ['paid', 'shipped', 'completed']);
            })
            ->sum('quantity');

        return (int) $this->sold_count + $orderSold;
    }

    public function totalSalesAmount(): float
    {
        return (float) ($this->totalSold() * $this->price);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }

    public function ratingBreakdown(): array
    {
        $total = $this->reviewsCount();
        $breakdown = [];
        for ($star = 5; $star >= 1; $star--) {
            $count = $this->reviews()->where('rating', $star)->count();
            $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
            $breakdown[$star] = [
                'count' => $count,
                'percentage' => $percentage,
            ];
        }
        return $breakdown;
    }
}
