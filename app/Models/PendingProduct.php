<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class PendingProduct extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'details',
        'description',
        'product_code',
        'price',
        'quantity',
        'images',
        'approved',
        'user_id',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        self::deleted(function (PendingProduct $record) {
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
}
