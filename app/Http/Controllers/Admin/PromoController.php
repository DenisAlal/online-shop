<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Traits\MediaUrlTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PromoController extends Controller
{
    use MediaUrlTrait;

    public function index(): Response
    {
        $promotions = Promotion::paginate(15)
            ->through(fn(Promotion $promotion) => [
                ...$promotion->toArray(),
                'image' => $this->mediaUrl($promotion),
            ]);

        return Inertia::render('Admin/Promotions/Index', [
            'promotions' => $promotions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Promotions/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $promotion = Promotion::create($validated);

        if ($request->hasFile('image')) {
            $promotion->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return redirect()->route('admin.promo.index');
    }

    public function show(Promotion $promotion): RedirectResponse
    {
        return redirect()->route('admin.promo.edit', $promotion);
    }

    public function edit(Promotion $promotion): Response
    {
        return Inertia::render('Admin/Promotions/Edit', [
            'promotion' => [
                ...$promotion->toArray(),
                'image' => $this->mediaUrl($promotion),
            ],
        ]);
    }

    public function update(Request $request, Promotion $promotion): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link_url' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $promotion->update($validated);

        if ($request->hasFile('image')) {
            $promotion->clearMediaCollection('images');
            $promotion->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return redirect()->route('admin.promo.index');
    }

    public function destroy(Request $request, Promotion $promotion): RedirectResponse
    {
        $promotion->delete();

        $page = $request->integer('page');
        if ($page > 1 && Promotion::paginate(15, ['*'], 'page', $page)->isEmpty()) {
            $page--;
        }

        return redirect()->route('admin.promo.index', ['page' => $page ?: null]);
    }
}
