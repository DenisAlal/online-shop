<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Traits\MediaUrlTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    use MediaUrlTrait;
    public function index(): Response
    {
        $products = Product::with('category')
            ->paginate(15)
            ->through(fn (Product $product) => [
                ...$product->toArray(),
                'image' => $this->mediaUrl($product),
            ]);

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
        ]);
    }

    public function create(): Response
    {
        $categories = Category::all();

        return Inertia::render('Admin/Products/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|integer|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.value' => 'required|string',
        ]);

        $product = Product::create($validated);

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('images');
        }

        foreach ($request->input('attributes', []) as $attr) {
            $attribute = Attribute::firstOrCreate(['name' => $attr['name']]);
            ProductAttribute::create([
                'product_id' => $product->id,
                'attribute_id' => $attribute->id,
                'value' => $attr['value'],
            ]);
        }

        return redirect()->route('admin.products.index');
    }

    public function edit(Product $product): Response
    {
        $categories = Category::all();

        $product->load('attributes.attribute');

        return Inertia::render('Admin/Products/Edit', [
            'product' => [
                ...$product->toArray(),
                'image' => $this->mediaUrl($product),
            ],
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,'.$product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|integer|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.value' => 'required|string',
        ]);

        $product->update($validated);

        if ($request->hasFile('image')) {
            $product->clearMediaCollection('images');
            $product->addMediaFromRequest('image')->toMediaCollection('images');
        }

        ProductAttribute::where('product_id', $product->id)->delete();
        foreach ($request->input('attributes', []) as $attr) {
            $attribute = Attribute::firstOrCreate(['name' => $attr['name']]);
            ProductAttribute::create([
                'product_id' => $product->id,
                'attribute_id' => $attribute->id,
                'value' => $attr['value'],
            ]);
        }

        return redirect()->route('admin.products.index');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product->delete();

        $page = $request->integer('page');
        if ($page > 1 && Product::paginate(15, ['*'], 'page', $page)->isEmpty()) {
            $page--;
        }

        return redirect()->route('admin.products.index', ['page' => $page ?: null]);
    }
}
