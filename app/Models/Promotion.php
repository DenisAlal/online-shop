<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'title',
    'subtitle',
    'description',
    'link_url',
    'type',
    'sort_order',
    'is_active',
    'starts_at',
    'ends_at',
])]
class Promotion extends Model implements HasMedia
{
    use InteractsWithMedia;
}
