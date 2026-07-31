<?php

namespace App\Models;

use App\Interfaces\HasMediaUrlInterface;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'title',
    'description',
    'link_url',
    'sort_order',
    'is_active',
    'starts_at',
    'ends_at',
])]
class Promotion extends Model implements HasMedia, HasMediaUrlInterface
{
    use InteractsWithMedia;
}
