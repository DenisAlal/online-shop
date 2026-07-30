<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name'
])]
class Attribute extends Model
{
    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
