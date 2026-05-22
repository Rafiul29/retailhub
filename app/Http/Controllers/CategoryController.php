<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['subcategories' => function($query) {
                $query->withCount('products')->latest();
            }])
            ->withCount('products')
            ->whereNull('parent_id')
            ->latest()
            ->paginate(10);
            
        $parentCategories = Category::whereNull('parent_id')->latest()->get();
        
        return view('categories.index', compact('categories', 'parentCategories'));
    }

    public function store(Request $request)
    {
        session()->flash('category_modal_action', 'create');

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        $data['slug'] = str($request->name)->slug();
        $data['status'] = $request->has('status');

        unset($data['image']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        session()->flash('category_modal_action', 'edit');
        session()->flash('category_id', $category->id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        $data['slug'] = str($request->name)->slug();
        $data['status'] = $request->has('status');

        unset($data['image']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category with associated products.');
        }

        if ($category->subcategories()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category that has subcategories.');
        }

        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
