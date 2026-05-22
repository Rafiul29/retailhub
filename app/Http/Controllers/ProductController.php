<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory', 'supplier'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('min_price')) {
            $query->where('selling_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('selling_price', '<=', $request->max_price);
        }

        $products   = $query->paginate(10)->withQueryString();
        $categories = Category::whereNull('parent_id')->with('subcategories')->get();
        $suppliers  = Supplier::all();
        
        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        session()->flash('modal', 'add');

        $request->validate([
            'name'           => 'required|string|max:255',
            'barcode'        => 'required|string|unique:products',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level'  => 'required|integer|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->validated();
        unset($data['image']); // handle image separately

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        AuditLogService::log('product_created', $product, [], $product->only([
            'name', 'barcode', 'purchase_price', 'selling_price', 'stock_quantity', 'reorder_level',
        ]));

        return redirect()->route('products.index')->with('success', 'Product registered successfully.');
    }

    public function update(Request $request, Product $product)
    {
        session()->flash('modal', 'edit');

        $request->validate([
            'name'           => 'required|string|max:255',
            'barcode'        => 'required|string|unique:products,barcode,' . $product->id,
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level'  => 'required|integer|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        

        $oldValues = $product->only(['name', 'purchase_price', 'selling_price', 'stock_quantity', 'reorder_level']);
        $data = $request->validated();
        unset($data['image']); // don't overwrite existing image unless a new one is uploaded

        if ($request->hasFile('image')) {
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        $newValues = $product->fresh()->only(['name', 'purchase_price', 'selling_price', 'stock_quantity', 'reorder_level']);

        if ($oldValues !== $newValues) {
            $action = ($oldValues['selling_price'] != $newValues['selling_price'] ||
                       $oldValues['purchase_price'] != $newValues['purchase_price'])
                ? 'price_changed'
                : 'product_updated';

            AuditLogService::log($action, $product, $oldValues, $newValues);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->saleItems()->count() > 0) {
            return redirect()->route('products.index')->with('error', 'Cannot delete product with existing sales history.');
        }

        AuditLogService::log('product_deleted', $product, $product->only([
            'name', 'barcode', 'purchase_price', 'selling_price', 'stock_quantity',
        ]), []);

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product removed from catalog.');
    }
}
