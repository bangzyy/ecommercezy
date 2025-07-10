<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index()
    {
        $validSorts = ['product_name', 'category', 'price', 'created_at'];
        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');

        if (!in_array($sort, $validSorts)) {
            $sort = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }
        $products = Product::with('category');
        if ($sort === 'category') {
            // Join ke tabel categories supaya bisa sorting berdasarkan category_name
            $products = $products->select('products.*')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->orderBy('categories.category_name', $direction);
        } else {
            $products = $products->orderBy($sort, $direction);
        }
        $products = $products->paginate(10)->withQueryString();
        return view('admin.products.index', compact('products'));
    }
    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('admin.products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50'
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        $product = Product::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);
        // Upload & simpan galeri foto
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $galleryImage) {
                $galleryPath = $galleryImage->store('product_images', 'public');
                // Simpan ke tabel product_images
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $galleryPath,
                ]);
            }
        }
        // Simpan colors kalau ada
        if ($request->colors) {
            foreach ($request->colors as $color) {
                if (!empty($color)) {
                    $product->colors()->create([
                        'color' => $color
                    ]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created!');
    }
    public function edit(Product $product)
    {
        $categories = Category::orderBy('category_name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50',
            'existing_colors' => 'nullable|array',
            'existing_colors.*' => 'nullable|string|max:50',
        ]);
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }
        $product->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imagePath,
        ]);
        // Update existing colors
        if ($request->has('existing_colors')) {
            foreach ($request->existing_colors as $id => $colorValue) {
                if (!is_null($colorValue) && $colorValue !== '') {

                    $product->colors()->where('id', $id)->update(['color' => $colorValue]);
                }
            }
        }
        // Tambah new colors
        if ($request->has('colors')) {
            foreach ($request->colors as $newColor) {
                if (!empty($newColor)) {
                    $product->colors()->create(['color' => $newColor]);
                }
            }
        }
        // Hapus colors yang dihapus
        if ($request->has('deleted_colors')) {
            $product->colors()->whereIn('id', $request->deleted_colors)->delete();
        }

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
    // for single products
    public function show($id)
    {
        $product = Product::with(['reviews.user', 'colors', 'images'])->findOrFail($id);

        return view('single-products', compact('product'));
    }
    // Short By Category
    public function productsByCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->latest()->get();

        return view('by_category', compact('category', 'products'));
    }
    public function search(Request $request)
    {
        $query = trim($request->input('query')); // trim untuk hilangkan spasi di awal & akhir
        if ($query === '') {
            // Kalau kosong atau cuma spasi, bisa return hasil kosong atau redirect
            $products = collect(); // koleksi kosong
            return view('product.search_results', compact('products', 'query'));
        }
        // Kalau ada input valid, lakukan pencarian
        $products = \App\Models\Product::where('product_name', 'LIKE', "%{$query}%")->get();
        return view('product.search_results', compact('products', 'query'));
    }
}
