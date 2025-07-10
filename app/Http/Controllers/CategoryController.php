<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'new');
        $categories = match ($sort) {
            'old' => Category::orderBy('created_at', 'asc')->paginate(10),
            default => Category::orderBy('created_at', 'desc')->paginate(10),
        };
        return view('admin.categories.index', compact('categories', 'sort'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function main()
    {
        $categories = Category::all();
        return view('categories', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }
        Category::create([
            'category_name' => $request->category_name,
            'slug' => Str::slug($request->category_name),
            'description' => $request->description,
            'image' => $imagePath ?? 'default.png',
        ]);
        return redirect()->route('categories.index')->with('success', 'Category created!');
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $category->id . '|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);
        $image = $category->image;
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }
        $category->update([
            'category_name' => $request->category_name,
            'slug' => Str::slug($request->category_name),
        ]);
        return redirect()->route('categories.index')->with('success', 'Category updated!');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted!');
    }
}
