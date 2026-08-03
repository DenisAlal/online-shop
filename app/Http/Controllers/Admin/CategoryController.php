<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(): Response
    {
        $categories = Category::with('parent')
            ->paginate(15);

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
        ]);
    }

    public function create(): Response
    {
        $parentCategories = Category::all();

        return Inertia::render('Admin/Categories/Create', [
            'parentCategories' => $parentCategories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'parent_id' => ['nullable', 'exists:categories,id', $this->depthRule()],
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category): Response
    {
        $parentCategories = Category::where('id', '!=', $category->id)->get();

        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category,
            'parentCategories' => $parentCategories,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => ['nullable', 'exists:categories,id', $this->depthRule()],
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index');
    }

    private function depthRule(): \Closure
    {
        return function (string $attribute, $value, \Closure $fail): void {
            if (! $value) {
                return;
            }

$depth = $this->categoryDepth((int) $value);

            if ($depth >= 2) {
                $fail('Максимальная вложенность категорий — 3 уровня.');
            }
        };
    }

    private function categoryDepth(int $categoryId, int $depth = 0): int
    {
        $category = Category::with('parent')->find($categoryId);

        if (! $category->parent) {
            return $depth;
        }

        return $this->categoryDepth($category->parent->id, $depth + 1);
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $category->delete();

        $page = $request->integer('page');
        if ($page > 1 && Category::paginate(15, ['*'], 'page', $page)->isEmpty()) {
            $page--;
        }

        return redirect()->route('admin.categories.index', ['page' => $page ?: null]);
    }
}
