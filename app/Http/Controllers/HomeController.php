<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Traits\MediaUrlTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    use MediaUrlTrait;

    public function __invoke(Request $request): Response
    {
        $promotions = Promotion::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Promotion $promotion) => [
                ...$promotion->toArray(),
                'image' => $this->mediaUrl($promotion),
            ]);

        return Inertia::render('Index', [
            'promotions' => $promotions,
        ]);
    }
}
