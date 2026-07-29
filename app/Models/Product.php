<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'category_id',
    'name',
    'slug',
    'description',
    'price',
    'discount',
    'stock_quantity',
    'is_active',
])]
class Product extends Model
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
