<?php

namespace App\Models;

use Binafy\LaravelCart\Cartable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model implements Cartable
{
    protected $fillable = [
        'name',
        'slug',
        'details',
        'description',
        'price',
        'discounted_price',
        'quantity',
        'product_code',
        'images',
        'user_id',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        self::deleted(function (Product $record) {
            Storage::disk('public')->delete($record->images);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function getPrice(): float
    {
        if ($this->discounted_price) {
            return (float) $this->discounted_price;
        }

        return (float) $this->price;
    }

    public function getDiscountedPrice(): float
    {
        return $this->discounted_price;
    }

    public function sortByBestSelling($limit = 10)
    {
        return Product::selectRaw('products.*, SUM(order_items.quantity) as total_sold')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
}
