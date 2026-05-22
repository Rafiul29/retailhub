@extends('layouts.app')

@section('header', 'Product Catalog')

@section('content')
    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-success" class="fixed top-6 right-6 z-[200] bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 text-sm font-bold animate-fade-in">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div id="flash-error" class="fixed top-6 right-6 z-[200] bg-rose-500 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-3 text-sm font-bold">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
        </div>
    @endif

    <div class="flex flex-col gap-8">
        <!-- Header with Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-1">Total Product</p>
                <h3 class="text-2xl font-extrabold text-slate-900">{{ $products->total() }}</h3>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-1">Active Categories</p>
                <h3 class="text-2xl font-extrabold text-indigo-600">{{ $categories->count() }}</h3>
            </div>
            <div
                class="bg-indigo-600 p-6 rounded-[2rem] shadow-xl shadow-indigo-500/20 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] opacity-60 mb-1">Inventory Value</p>
                    <h3 class="text-2xl font-extrabold text-white">
                        {{ $settings['currency_symbol'] ?? '$' }}{{ number_format($products->sum(fn($p) => $p->purchase_price * $p->stock_quantity), 0) }}
                    </h3>
                </div>
                <i class="fas fa-coins absolute bottom-[-10px] right-[-10px] text-6xl opacity-10 rotate-12"></i>
            </div>
            <div class="flex flex-col gap-2">
                <button onclick="document.getElementById('add-product-modal').classList.remove('hidden')"
                    class="bg-slate-900 text-white px-6 py-3.5 rounded-2xl font-extrabold shadow-xl hover:bg-slate-800 transition-all flex items-center justify-center gap-3 active:scale-95 text-sm">
                    <i class="fas fa-plus"></i> New Product
                </button>
                <button type="button" id="bulk-print-btn"
                    class="bg-white text-slate-700 border border-slate-200 px-6 py-3.5 rounded-2xl font-bold hover:bg-slate-50 transition-all flex items-center justify-center gap-3 text-xs w-full">
                    <i class="fas fa-barcode"></i> Print Barcodes
                </button>
                <form id="bulk-print-form" action="{{ route('products.barcodes.print') }}" method="GET" target="_blank"
                    class="hidden"></form>
            </div>
            <div class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <a href="{{ route('products.export') }}"
                        class="flex-1 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-2xl font-bold text-[10px] uppercase tracking-widest text-center hover:bg-emerald-100 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-file-export"></i> Export
                    </a>
                    <!-- <button onclick="document.getElementById('import-file').click()"
                                                                    class="flex-1 bg-amber-50 text-amber-600 px-4 py-3 rounded-2xl font-bold text-[10px] uppercase tracking-widest text-center hover:bg-amber-100 transition-all flex items-center justify-center gap-2">
                                                                    <i class="fas fa-file-import"></i> Import
                                                                </button> -->
                </div>
                <form id="import-form" action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data"
                    class="hidden">
                    @csrf
                    <input type="file" id="import-file" name="file"
                        onchange="document.getElementById('import-form').submit()">
                </form>
                <div class="flex gap-2">
                    <a href="{{ route('stock.export') }}"
                        class="flex-1 bg-blue-50 text-blue-600 px-4 py-3 rounded-2xl font-bold text-[10px] uppercase tracking-widest text-center hover:bg-blue-100 transition-all">Stock
                        Export</a>
                    <!-- <button onclick="document.getElementById('stock-import-file').click()"
                                                                class="flex-1 bg-slate-50 text-slate-500 px-4 py-3 rounded-2xl font-bold text-[10px] uppercase tracking-widest text-center hover:bg-slate-100 transition-all">Stock
                                                                Sync</button> -->
                </div>
                <form id="stock-import-form" action="{{ route('stock.import') }}" method="POST"
                    enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input type="file" id="stock-import-file" name="file"
                        onchange="document.getElementById('stock-import-form').submit()">
                </form>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative z-10">
            <form id="filter-form" action="{{ route('products.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Search
                        Name / Barcode</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-4 text-slate-400"></i>
                        <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                            class="w-full border-0 bg-slate-50 py-3 pl-10 px-5 text-sm font-semibold rounded-xl focus:ring-4 focus:ring-indigo-600/10"
                            placeholder="Type here...">
                    </div>
                </div>
                <div>
                    <label
                        class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Category</label>
                    <select name="category_id" id="category-filter"
                        class="w-full border-0 bg-slate-50 py-3 px-5 text-sm font-semibold rounded-xl focus:ring-4 focus:ring-indigo-600/10 cursor-pointer">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @foreach($category->subcategories as $sub)
                                <option value="{{ $sub->id }}" {{ request('category_id') == $sub->id ? 'selected' : '' }}>
                                    &nbsp;&nbsp;&nbsp;&mdash; {{ $sub->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Min
                        Price</label>
                    <input type="number" step="0.01" name="min_price" id="min-price-input"
                        value="{{ request('min_price') }}"
                        class="w-full border-0 bg-slate-50 py-3 px-5 text-sm font-semibold rounded-xl focus:ring-4 focus:ring-indigo-600/10"
                        placeholder="0.00">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Max
                        Price</label>
                    <input type="number" step="0.01" name="max_price" id="max-price-input"
                        value="{{ request('max_price') }}"
                        class="w-full border-0 bg-slate-50 py-3 px-5 text-sm font-semibold rounded-xl focus:ring-4 focus:ring-indigo-600/10"
                        placeholder="9999.00">
                </div>
                <button type="submit" class="hidden">Filter</button>
            </form>
        </div>

        <!-- Product Table -->
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-10 py-8 border-b border-slate-50 flex justify-between items-center bg-white">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">Registered Inventory</h2>
                    <p class="text-sm font-medium text-slate-400 mt-1">Manage pricing and stock levels globally</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-5 w-10">
                                <input type="checkbox" id="select-all"
                                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                            </th>
                            <th class="px-4 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Product
                                Identity</th>
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Hierarchy
                            </th>
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Pricing
                                Cost/Sell</th>
                            <th class="px-6 py-5 text-[10px] font-bold uppercase tracking-widest text-slate-400">Inventory
                                Status</th>
                            <th
                                class="px-10 py-5 text-right text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($products as $product)
                            <tr class="group hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-6 border-l-4 border-transparent group-hover:border-indigo-500/10">
                                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}"
                                        class="product-checkbox rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                                </td>
                                <td class="px-4 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-14 w-14 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 shadow-sm overflow-hidden flex-shrink-0">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" class="h-full w-full object-cover">
                                            @else
                                                <i class="fas fa-tag"></i>
                                            @endif
                                        </div>
                                        <div class="truncate">
                                            <p class="text-sm font-bold text-slate-900 truncate">{{ $product->name }}</p>
                                            <p class="text-[10px] font-extrabold tracking-wider text-slate-400 mt-0.5">
                                                {{ $product->barcode }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="inline-flex max-w-fit items-center rounded-lg bg-indigo-50 px-2.5 py-1 text-[10px] font-bold text-indigo-600 border border-indigo-100/50">
                                            {{ $product->category->name }}
                                        </span>
                                        @if($product->subcategory)
                                            <span
                                                class="inline-flex max-w-fit items-center rounded-lg bg-slate-50 px-2.5 py-1 text-[10px] font-bold text-slate-500 border border-slate-100/50 mt-1">
                                                <i class="fas fa-level-up-alt rotate-90 mr-1.5 opacity-60"></i>
                                                {{ $product->subcategory->name }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-6 font-bold text-sm">
                                    <span
                                        class="text-slate-400">{{ $settings['currency_symbol'] ?? '$' }}{{ number_format($product->purchase_price, 2) }}</span>
                                    <span class="text-slate-300 mx-1">/</span>
                                    <span
                                        class="text-emerald-500">{{ $settings['currency_symbol'] ?? '$' }}{{ number_format($product->selling_price, 2) }}</span>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2 mb-1">
                                            @if($product->stock_quantity <= $product->reorder_level)
                                                <i class="fas fa-exclamation-circle text-rose-500 text-xs animate-pulse"></i>
                                                <span class="text-sm font-bold text-rose-600">{{ $product->stock_quantity }}
                                                    units</span>
                                            @else
                                                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                                <span class="text-sm font-bold text-slate-700">{{ $product->stock_quantity }}
                                                    units</span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] font-bold text-slate-400">Min.
                                            {{ $product->reorder_level }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-6 text-right space-x-1 whitespace-nowrap">
                                    <a href="{{ route('products.barcodes.print') }}?product_ids[]={{ $product->id }}"
                                        target="_blank"
                                        class="h-10 w-10 inline-flex items-center justify-center rounded-xl bg-indigo-50/50 text-indigo-500 hover:bg-indigo-600 hover:text-white transition-all shadow-sm"
                                        title="Print Barcode">
                                        <i class="fas fa-barcode text-[10px]"></i>
                                    </a>
                                    <button onclick="editProduct({{ json_encode($product) }})"
                                        class="h-10 w-10 inline-flex items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-400 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm"
                                        title="Edit Product">
                                        <i class="fas fa-pen-nib text-[10px]"></i>
                                    </button>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="h-10 w-10 inline-flex items-center justify-center rounded-xl bg-rose-50 border border-rose-100/50 text-rose-500 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm"
                                            onclick="return confirm('Delete item?')">
                                            <i class="fas fa-trash-alt text-[10px]"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-24 text-center">
                                    <div class="opacity-10 mb-4 flex justify-center">
                                        <div class="h-24 w-24 rounded-full bg-slate-900 flex items-center justify-center">
                                            <i class="fas fa-boxes text-4xl text-white"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-extrabold text-slate-900 mb-1">No products found</h3>
                                    <p class="text-sm font-medium text-slate-500">Try adjusting your filters or add a new
                                        product</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Section -->
            @if($products->hasPages())
                <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="add-product-modal"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden overflow-y-auto pt-10 pb-10">
        <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl my-auto">
            <div class="p-10">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900">Catalog Registry</h2>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Add a new product to
                            inventory</p>
                    </div>
                    <button onclick="document.getElementById('add-product-modal').classList.add('hidden')"
                        class="h-12 w-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    @csrf
                    <div class="md:col-span-2">
                        <label
                            class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Product
                            Media</label>
                        <div
                            class="relative w-full h-32 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center hover:bg-indigo-50/30 hover:border-indigo-300 transition-all overflow-hidden group">
                            <div class="text-slate-400 text-center flex flex-col items-center" id="add-image-placeholder">
                                <i
                                    class="fas fa-cloud-upload-alt text-2xl mb-2 text-indigo-300 group-hover:-translate-y-1 transition-transform"></i>
                                <span class="text-xs font-bold text-slate-600">Click to upload image</span>
                            </div>
                            <img id="add-image-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                            <input type="file" name="image" id="add-image-input"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <x-input label="Product Name" name="name" required />
                    </div>
                    <div>
                        <x-input label="Barcode / SKU" name="barcode" required />
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Supplier</label>
                        <select name="supplier_id"
                            class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 cursor-pointer">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Main
                            Category</label>
                        <select name="category_id" id="add_category_id"
                            class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 cursor-pointer">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Subcategory
                            (Optional)</label>
                        <select name="subcategory_id" id="add_subcategory_id"
                            class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 cursor-pointer">
                            <option value="">Select Subcategory</option>
                            @foreach($categories as $category)
                                @foreach($category->subcategories as $sub)
                                    <option value="{{ $sub->id }}" data-parent="{{ $category->id }}">{{ $sub->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input label="Cost Price" name="purchase_price" type="number" step="0.01" required />
                    </div>
                    <div>
                        <x-input label="Retail Price" name="selling_price" type="number" step="0.01" required />
                    </div>
                    <div>
                        <x-input label="In-Stock Quantity" name="stock_quantity" type="number" required />
                    </div>
                    <div>
                        <x-input label="Low Stock Level" name="reorder_level" type="number" required />
                    </div>

                    <div class="md:col-span-2 mt-4 pt-6 border-t border-slate-50">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-2xl shadow-xl shadow-indigo-600/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i> Register to Catalog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="edit-product-modal"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden overflow-y-auto pt-10 pb-10">
        <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl my-auto">
            <div class="p-10">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900">Update Catalog Item</h2>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Modify existing
                            product details</p>
                    </div>
                    <button onclick="document.getElementById('edit-product-modal').classList.add('hidden')"
                        class="h-12 w-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="edit-product-form" action="" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    @csrf
                    @method('PUT')

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Update
                            Product Media</label>
                        <div
                            class="relative w-full h-32 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center hover:bg-emerald-50/30 hover:border-emerald-300 transition-all overflow-hidden group">
                            <div class="text-slate-400 text-center flex flex-col items-center" id="edit-image-placeholder">
                                <i
                                    class="fas fa-image text-2xl mb-2 text-emerald-300 group-hover:-translate-y-1 transition-transform"></i>
                                <span class="text-xs font-bold text-slate-600">Upload new image to replace</span>
                            </div>
                            <img id="edit-image-preview" src="" class="absolute inset-0 w-full h-full object-cover hidden">
                            <input type="file" name="image" id="edit-image-input"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <x-input label="Product Name" name="name" id="edit_name" required />
                    </div>
                    <div>
                        <x-input label="Barcode / SKU" name="barcode" id="edit_barcode" required />
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Supplier</label>
                        <select name="supplier_id" id="edit_supplier_id"
                            class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 cursor-pointer">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Main
                            Category</label>
                        <select name="category_id" id="edit_category_id"
                            class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 cursor-pointer">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ms-1">Subcategory</label>
                        <select name="subcategory_id" id="edit_subcategory_id"
                            class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 cursor-pointer">
                            <option value="">Select Subcategory</option>
                            @foreach($categories as $category)
                                @foreach($category->subcategories as $sub)
                                    <option value="{{ $sub->id }}" data-parent="{{ $category->id }}">{{ $sub->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input label="Cost Price" name="purchase_price" id="edit_purchase_price" type="number" step="0.01"
                            required />
                    </div>
                    <div>
                        <x-input label="Retail Price" name="selling_price" id="edit_selling_price" type="number" step="0.01"
                            required />
                    </div>
                    <div>
                        <x-input label="In-Stock Quantity" name="stock_quantity" id="edit_stock_quantity" type="number"
                            required />
                    </div>
                    <div>
                        <x-input label="Low Stock Level" name="reorder_level" id="edit_reorder_level" type="number"
                            required />
                    </div>

                    <div class="md:col-span-2 mt-4 pt-6 border-t border-slate-50">
                        <button type="submit"
                            class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 px-6 rounded-2xl shadow-xl shadow-emerald-500/20 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Update Inventory Focus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // ── Auto-reopen modal on validation error ──────────────────────────────────
            @if($errors->any())
                document.addEventListener('DOMContentLoaded', function () {
                    const errorModal = '{{ session('modal') }}';
                    if (errorModal === 'edit') {
                        document.getElementById('edit-product-modal').classList.remove('hidden');
                    } else {
                        // Default: reopen Add modal
                        document.getElementById('add-product-modal').classList.remove('hidden');
                    }
                    // Auto-dismiss flash after 5s
                    setTimeout(() => {
                        const f = document.getElementById('flash-success') || document.getElementById('flash-error');
                        if (f) f.remove();
                    }, 5000);
                });
            @endif

            // Auto-dismiss success flash
            setTimeout(() => {
                const f = document.getElementById('flash-success');
                if (f) f.remove();
            }, 4000);

            // Realtime search with debounce
            let searchTimeout;
            const filterForm = document.getElementById('filter-form');
            const inputs = document.querySelectorAll('#search-input, #category-filter, #min-price-input, #max-price-input');

            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        filterForm.submit();
                    }, 600); // 600ms debounce
                });
            });

            document.getElementById('select-all').addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });

            document.getElementById('bulk-print-btn').addEventListener('click', function () {
                const selected = document.querySelectorAll('.product-checkbox:checked');
                const form = document.getElementById('bulk-print-form');
                form.innerHTML = ''; // clear previous inputs

                if (selected.length === 0) {
                    if (!confirm('No products selected. Print barcodes for all items?')) return;
                }

                selected.forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'product_ids[]';
                    input.value = cb.value;
                    form.appendChild(input);
                });

                form.submit();
            });

            // Handle Subcategory dynamic select options based on parent
            function filterSubcategories(parentSelectId, subcategorySelectId, selectedSubId = null) {
                const categorySelect = document.getElementById(parentSelectId);
                const subcategorySelect = document.getElementById(subcategorySelectId);

                categorySelect.addEventListener('change', function () {
                    const parentId = this.value;
                    const options = subcategorySelect.querySelectorAll('option');

                    options.forEach(opt => {
                        if (opt.value === "") return; // keeps 'Select Subcategory' always visible
                        if (opt.dataset.parent === parentId) {
                            opt.style.display = 'block';
                        } else {
                            opt.style.display = 'none';
                        }
                    });
                    subcategorySelect.value = '';
                });

                // Trigger change initially to filter correctly
                const event = new Event('change');
                categorySelect.dispatchEvent(event);

                if (selectedSubId) {
                    subcategorySelect.value = selectedSubId;
                }
            }

            // Init for Create Form
            filterSubcategories('add_category_id', 'add_subcategory_id');

            // Image Preview Handlers
            function setupImagePreview(inputId, previewId, placeholderId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);

                if (input) {
                    input.addEventListener('change', function () {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                preview.src = e.target.result;
                                preview.classList.remove('hidden');
                                placeholder.classList.add('hidden');
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                }
            }

            setupImagePreview('add-image-input', 'add-image-preview', 'add-image-placeholder');
            setupImagePreview('edit-image-input', 'edit-image-preview', 'edit-image-placeholder');

            function editProduct(product) {
                const form = document.getElementById('edit-product-form');
                form.action = `/products/${product.id}`;

                document.getElementById('edit_name').value = product.name;
                document.getElementById('edit_barcode').value = product.barcode;
                document.getElementById('edit_category_id').value = product.category_id;
                document.getElementById('edit_supplier_id').value = product.supplier_id;
                document.getElementById('edit_purchase_price').value = product.purchase_price;
                document.getElementById('edit_selling_price').value = product.selling_price;
                document.getElementById('edit_stock_quantity').value = product.stock_quantity;
                document.getElementById('edit_reorder_level').value = product.reorder_level;

                // Filter subcategories for this specific parent and select it
                filterSubcategories('edit_category_id', 'edit_subcategory_id', product.subcategory_id);

                // Handle edit image preview
                const editPreview = document.getElementById('edit-image-preview');
                const editPlaceholder = document.getElementById('edit-image-placeholder');

                if (product.image) {
                    editPreview.src = '/storage/' + product.image;
                    editPreview.classList.remove('hidden');
                    editPlaceholder.classList.add('hidden');
                } else {
                    editPreview.src = '';
                    editPreview.classList.add('hidden');
                    editPlaceholder.classList.remove('hidden');
                }

                document.getElementById('edit-product-modal').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection