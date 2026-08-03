<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'parent_id',
    'name',
    'slug',
    'description',
])]
class Category extends Model
{
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function tree(): array
    {
        $all = self::all();

        return $all
            ->where('parent_id', null)
            ->map(fn ($cat) => self::buildBranch($cat, $all))
            ->values()
            ->toArray();
    }

    private static function buildBranch(self $cat, $all): array
    {
        return [
            'id' => $cat->id,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'children' => $all
                ->where('parent_id', $cat->id)
                ->map(fn ($child) => self::buildBranch($child, $all))
                ->values()
                ->toArray(),
        ];
    }
}
