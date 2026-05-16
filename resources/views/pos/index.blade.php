@extends('layouts.app')

@section('header', 'POS Workstation')

@section('content')
    @php
        $currency = $settings['currency_symbol'] ?? '$';
        $tax_rate = $settings['tax_percentage'] ?? 5;
    @endphp

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">
        <!-- Left: Cart & Product Search -->
        <div class="lg:col-span-8 space-y-3">
            <div class="flex flex-col bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden min-h-[700px]">
                <!-- Search & Actions Header -->
                <div
                    class="flex flex-col sm:flex-row items-center gap-3 border-b border-slate-100 px-6 py-4 bg-slate-50/50">
                    <div class="relative flex-1 w-full group">
                        <div
                            class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" id="product-search"
                            class="w-full border border-slate-200 bg-white py-3 pl-11 pr-20 text-sm font-semibold rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 shadow-sm placeholder:text-slate-400 transition-all font-sans"
                            placeholder="Search Name, Barcode, Category...">
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2">
                            <span
                                class="hidden sm:inline-block rounded-md bg-slate-100 px-2 py-1 text-[9px] font-bold text-slate-500 border border-slate-200 uppercase tracking-widest">Alt+P</span>
                        </div>
                    </div>
                </div>

                <!-- Cart Table -->
                <div class="flex-1 overflow-y-auto custom-scrollbar">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead class="sticky top-0 z-10 bg-white/95 backdrop-blur-md">
                            <tr class="bg-slate-50/50">
                                <th
                                    class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                                    Product Detail</th>
                                <th
                                    class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                                    Price</th>
                                <th
                                    class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100 text-center">
                                    Quantity</th>
                                <th
                                    class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                                    Subtotal</th>
                                <th
                                    class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items" class="divide-y divide-slate-100">
                            <tr id="empty-cart-row">
                                <td colspan="5" class="py-32 text-center text-slate-300">
                                    <div
                                        class="bg-indigo-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-shopping-basket text-3xl text-indigo-200"></i>
                                    </div>
                                    <p class="text-base font-bold text-slate-400">Your Cart is Empty</p>
                                    <p class="text-[11px] font-medium opacity-60 uppercase tracking-widest mt-1">Add
                                        products to begin your order</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Summary & Customer -->
        <div class="lg:col-span-4 space-y-4">
            <!-- Customer Section -->
            <div class="rounded-3xl bg-white p-6 shadow-xl border border-slate-200 space-y-5 relative overflow-hidden">
                <div class="flex items-center justify-between relative z-10">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Customer Details</h3>
                    <button type="button" id="search-customer-btn"
                        class="h-8 px-3 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider hover:bg-indigo-600 hover:text-white transition-all flex items-center gap-1.5 border border-indigo-100">
                        <i class="fas fa-search-plus"></i> Search Registered Customers
                    </button>
                </div>

                <div id="selected-customer-display"
                    class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 hidden relative z-10 fade-in">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md"
                                id="customer-avatar-initial">W</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800 leading-none" id="display-customer-name">Walk-in
                                    Customer</h4>
                                <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-wider mt-1.5"
                                    id="display-customer-phone">Anonymous Customer</p>
                            </div>
                        </div>
                        <button type="button" id="clear-customer" class="text-slate-400 hover:text-rose-500 transition-all">
                            <i class="fas fa-times-circle text-lg"></i>
                        </button>
                    </div>
                </div>

                <div id="customer-form" class="space-y-3 relative z-10">
                    <div>
                        <input type="text" id="customer-name"
                            class="w-full border border-slate-200 bg-slate-50 py-3 px-4 text-xs font-semibold rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 placeholder:text-slate-400 transition-all"
                            placeholder="Full Name *">
                        <span id="customer-name-error" class="text-[10px] text-rose-500 font-bold hidden px-1 mt-1">Customer
                            name is required for order processing.</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" id="customer-phone"
                            class="w-full border border-slate-200 bg-slate-50 py-3 px-4 text-xs font-semibold rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 placeholder:text-slate-400 transition-all"
                            placeholder="Phone Number">
                        <input type="email" id="customer-email"
                            class="w-full border border-slate-200 bg-slate-50 py-3 px-4 text-xs font-semibold rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 placeholder:text-slate-400 transition-all"
                            placeholder="Email Address">
                    </div>
                    <input type="hidden" id="customer-id" value="">
                </div>
            </div>

            <!-- Totals & Checkout -->
            <div
                class="rounded-3xl bg-slate-800 p-6 text-white shadow-2xl relative overflow-hidden border border-slate-700">
                <div class="relative z-10 space-y-4">
                    <div
                        class="flex justify-between items-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                        <span>Cart Subtotal</span>
                        <span id="summary-subtotal" class="text-white">{{ $currency }}</span>
                    </div>
                    <div
                        class="flex justify-between items-center text-[11px] font-bold text-indigo-300 uppercase tracking-widest">
                        <span>Estimated Tax ({{ $tax_rate }}%)</span>
                        <span id="summary-tax" class="text-indigo-200">{{ $currency }}</span>
                    </div>
                    <div class="pt-4 border-t border-slate-700">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Order Total</span>
                            <span id="summary-total"
                                class="text-3xl font-black text-white tracking-tighter">{{ $currency }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 space-y-3 relative z-10">
                    <button type="button" id="finalize-btn"
                        class="w-full rounded-2xl py-4 text-base font-bold text-white flex items-center justify-center gap-3
                                                                                                                   bg-indigo-600 shadow-lg shadow-indigo-900/50 hover:bg-indigo-500 active:scale-[0.98] transition-all disabled:opacity-30 disabled:grayscale"
                        disabled>
                        <span>Proceed to Checkout</span>
                        <i class="fas fa-shopping-cart opacity-50"></i>
                    </button>
                    <button type="button" id="clear-cart-btn"
                        class="w-full py-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-rose-400 flex items-center justify-center gap-2 transition-colors">
                        <i class="fas fa-trash-alt text-xs"></i> Empty Cart
                    </button>
                </div>

                <!-- Background decor -->
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl"></div>
            </div>
        </div>
    </div>

    <!-- ═════════════════════ PRODUCT SEARCH MODAL ═════════════════════ -->
    <div id="product-search-modal" style="display:none;"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div
            class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden scale-in-center">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-white">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-md">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 leading-none">Product Finder</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1.5">Locate active nodes
                            in repository</p>
                    </div>
                </div>
                <button type="button"
                    class="close-search-modal h-8 w-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <div class="p-5 border-b border-slate-100">
                <div class="relative group">
                    <i
                        class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                    <input type="text" id="modal-product-input"
                        class="w-full border border-slate-200 bg-slate-50 py-3 pl-11 pr-5 text-sm font-semibold rounded-xl focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 transition-all"
                        placeholder="Search by name or barcode...">
                </div>
            </div>

            <div class="h-[400px] overflow-y-auto p-6 custom-scrollbar bg-slate-50/30">
                <div id="product-results" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-center">
                    <!-- Results injected here -->
                    <div class="col-span-full py-12 text-slate-300 font-bold uppercase tracking-widest text-[10px]">Ready
                        for node input</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═════════════════════ CUSTOMER SEARCH MODAL ═════════════════════ -->
    <div id="customer-search-modal" style="display:none;"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div
            class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden scale-in-center">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-white">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md">
                        <i class="fas fa-users-viewfinder"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 leading-none">Customer Search</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1.5">Find existing
                            customers in our database</p>
                    </div>
                </div>
                <button type="button"
                    class="close-customer-modal h-8 w-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <div class="p-5 border-b border-slate-100">
                <div class="relative group">
                    <i
                        class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-emerald-500 transition-colors"></i>
                    <input type="text" id="modal-customer-input"
                        class="w-full border border-slate-200 bg-slate-50 py-3 pl-11 pr-5 text-sm font-semibold rounded-xl focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 transition-all"
                        placeholder="Search by name, phone, or email...">
                </div>
            </div>

            <div class="h-[300px] overflow-y-auto p-4 custom-scrollbar bg-slate-50/30">
                <div id="customer-results" class="space-y-2">
                    <!-- Results injected here -->
                </div>
            </div>
        </div>
    </div>

    <!-- ═════════════════════ FINAL CHECKOUT MODAL ═════════════════════ -->
    <div id="finalizeModal" style="display:none;"
        class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-black/60 backdrop-blur-md">
        <div
            class="relative w-full max-w-4xl max-h-[90vh] overflow-hidden bg-white rounded-3xl shadow-2xl border border-slate-200 scale-in-center">
            <div class="flex flex-col h-full lg:flex-row">
                <!-- Left: Settlement -->
                <div class="p-8 flex-1 overflow-y-auto custom-scrollbar border-r border-slate-100">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Order Checkout</h2>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Review and
                                complete your purchase.</p>
                        </div>
                        <button id="close-finalize-btn"
                            class="h-10 w-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:text-rose-500 transition-all">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-4 block">Payment
                                Method</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="Cash" class="peer sr-only" checked>
                                    <div
                                        class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-slate-100 hover:border-indigo-100 transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 text-slate-400">
                                        <i class="fas fa-money-bill-wave text-xl"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">Cash</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="Card" class="peer sr-only">
                                    <div
                                        class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-slate-100 hover:border-indigo-100 transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 text-slate-400">
                                        <i class="fas fa-credit-card text-xl"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">Card</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="Credit" class="peer sr-only">
                                    <div
                                        class="flex flex-col items-center gap-2 p-4 rounded-2xl border-2 border-slate-100 hover:border-indigo-100 transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 text-slate-400">
                                        <i class="fas fa-landmark text-xl"></i>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">Store Credit</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 block">Amount
                                Paid</label>
                            <div class="relative">
                                <span
                                    class="absolute left-6 top-1/2 -translate-y-1/2 text-2xl font-black text-slate-300 group-focus-within:text-indigo-600 transition-colors">{{ $currency }}</span>
                                <input type="number" id="paid_amount_input" step="0.01" min="0"
                                    class="w-full border-2 border-slate-100 bg-slate-50 py-4 px-8 text-4xl font-black rounded-3xl focus:border-indigo-600 focus:bg-white transition-all text-slate-800 tracking-tighter"
                                    value="0.00">
                            </div>

                            <div
                                class="bg-slate-900 rounded-3xl p-6 text-white overflow-hidden shadow-xl border border-slate-700">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-500">Order
                                            Balance</p>
                                        <h3 id="due-amount-header"
                                            class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                                            Payment Status</h3>
                                    </div>
                                    <span id="due-amount-display"
                                        class="text-3xl font-black text-emerald-400 tracking-tighter">{{ $currency }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary Sidebar -->
                <div class="bg-indigo-600 p-8 text-white w-full lg:w-[350px] flex flex-col justify-between">
                    <div>
                        <div
                            class="flex items-center gap-2 mb-8 bg-white/10 w-fit px-4 py-1.5 rounded-full border border-white/10">
                            <span class="text-[9px] font-bold uppercase tracking-widest">Order Summary</span>
                        </div>

                        <div id="modal-items-list"
                            class="space-y-3 mb-8 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">
                            <!-- Items injected -->
                        </div>

                        <div class="space-y-3 border-t border-white/10 pt-6">
                            <div
                                class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest opacity-60">
                                <span>Subtotal</span>
                                <span id="modal-subtotal-display">{{ $currency }}</span>
                            </div>
                            <div
                                class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest opacity-60">
                                <span>Tax Total</span>
                                <span id="modal-tax-display">{{ $currency }}</span>
                            </div>
                            <div class="pt-4 border-t border-white/10">
                                <p class="text-[9px] font-bold uppercase tracking-widest opacity-40 mb-1">Total Amount</p>
                                <h1 id="modal-total-display" class="text-5xl font-black tracking-tighter text-white">
                                    {{ $currency }}
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8">
                        <button id="confirm-sale-btn"
                            class="w-full py-5 rounded-2xl text-xl font-bold text-indigo-600 bg-white shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                            <span>Place Order</span>
                            <i class="fas fa-shopping-bag opacity-30"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.02);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(79, 70, 229, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(79, 70, 229, 0.4);
        }

        .scale-in-center {
            animation: scale-in-center 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }

        @keyframes scale-in-center {
            0% {
                transform: scale(0.97);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .fade-in {
            animation: fade-in 0.3s ease-out forwards;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .product-card:hover {
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            let cart = [];
            let selectedCustomer = null;
            const TAX_RATE = {{ ($settings['tax_percentage'] ?? 5) / 100 }};
            const CURRENCY = '{{ $currency }}';
            let searchTimer;

            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

            /* ──────────────── PRODUCT SEARCH ENGINE ──────────────── */
            $('#product-search').on('keyup', function (e) {
                let query = $(this).val().trim();
                if (e.which === 13 && query) {
                    performProductSearch(query, true);
                } else {
                    clearTimeout(searchTimer);
                    if (query.length >= 2) {
                        searchTimer = setTimeout(() => performProductSearch(query, true), 200);
                    }
                }
            });

            $('#product-search').on('click', function () {
                let query = $(this).val().trim();
                $('#product-search-modal').fadeIn(150);
                $('#modal-product-input').val(query).focus();
                if (query.length >= 2) performProductSearch(query, false);
            });

            $('#modal-product-input').on('keyup', function (e) {
                let query = $(this).val().trim();
                clearTimeout(searchTimer);
                if (query.length >= 2) {
                    searchTimer = setTimeout(() => performProductSearch(query, false), 200);
                } else if (query.length === 0) {
                    $('#product-results').html('<div class="col-span-full py-12 text-slate-300 font-bold uppercase tracking-widest text-[10px]">Ready for node input</div>');
                }
            });

            function performProductSearch(query, triggerModal) {
                $.get('{{ route('pos.search') }}', { query: query }, function (res) {
                    if (res.success && res.products.length > 0) {
                        if (res.products.length === 1 && (res.products[0].barcode === query || res.products[0].name.toLowerCase() === query.toLowerCase())) {
                            addToCart(res.products[0]);
                            $('#product-search').val('');
                            $('#modal-product-input').val('');
                            $('#product-search-modal').fadeOut(100);
                        } else {
                            renderProductResults(res.products);
                            if (triggerModal) {
                                $('#product-search-modal').fadeIn(150);
                                $('#modal-product-input').val(query).focus();
                            }
                        }
                    } else {
                        $('#product-results').html('<div class="col-span-full py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">No matching resource found</div>');
                    }
                });
            }

            function renderProductResults(products) {
                let html = '';
                products.forEach(p => {
                    let catName = p.category ? p.category.name : 'Unknown Node';
                    let isOut = p.stock_quantity <= 0;
                    html += `
                                                                                            <div class="product-card bg-white border border-slate-200 p-4 rounded-xl cursor-pointer group shadow-sm hover:border-indigo-500 hover:shadow-lg transition-all ${isOut ? 'opacity-40 grayscale pointer-events-none' : ''}" data-product='${JSON.stringify(p).replace(/'/g, "&apos;")}'>
                                                                                                <div class="flex  gap-4">
                                                                                                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center overflow-hidden shrink-0 group-hover:bg-white transition-colors">
                                                                                                        ${p.image ? `<img src="/storage/${p.image}" class="w-full h-full object-cover">` : '<i class="fas fa-cube text-slate-300"></i>'}
                                                                                                    </div>
                                                                                                    <div class="flex-1 min-w-0">
                                                                                                    <div class="flex justify-between items-center"  > 
                                                                                                        <h4 class="text-xs font-bold text-slate-800 truncate">${p.name}</h4>
                                                                                                        <p class="text-[9px] font-bold text-indigo-500 uppercase tracking-wider mt-1">${catName}</p>
                                                                                                    </div>
                                                                                                        <div class="flex justify-between items-baseline mt-2">
                                                                                                            <span class="text-sm font-black text-slate-900">${CURRENCY}${parseFloat(p.selling_price).toFixed(2)}</span>
                                                                                                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full ${p.stock_quantity < 10 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600'}">Qty: ${p.stock_quantity}</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        `;
                });
                $('#product-results').html(html);
            }

            $(document).on('click', '.product-card', function () {
                let product = $(this).data('product');
                addToCart(product);
                $('#product-search-modal').fadeOut(100);
                $('#product-search').val('').focus();
            });

            $('.close-search-modal').on('click', () => $('#product-search-modal').fadeOut(100));

            /* ──────────────── CUSTOMERS ──────────────── */
            $('#search-customer-btn').on('click', () => $('#customer-search-modal').fadeIn(150).find('input').focus());
            $('.close-customer-modal').on('click', () => $('#customer-search-modal').fadeOut(100));

            $('#modal-customer-input').on('keyup', function () {
                let query = $(this).val().trim();
                if (query.length >= 2) {
                    $.get('{{ route('pos.customer.search') }}', { query: query }, function (res) {
                        if (res.success) renderCustomerResults(res.customers);
                    });
                }
            });

            function renderCustomerResults(customers) {
                let html = customers.length === 0 ? '<div class="text-center py-8 text-slate-400 font-bold uppercase tracking-widest text-[10px]">Registry Empty</div>' : '';
                customers.forEach(c => {
                    html += `
                                                                                            <div class="select-customer-row flex items-center justify-between p-3 rounded-xl bg-white border border-slate-100 hover:bg-slate-50 hover:border-indigo-200 transition-all cursor-pointer group" data-customer='${JSON.stringify(c).replace(/'/g, "&apos;")}'>
                                                                                                <div class="flex items-center gap-3">
                                                                                                    <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">${c.name.charAt(0)}</div>
                                                                                                    <div class="min-w-0">
                                                                                                        <h4 class="text-xs font-bold text-slate-800 truncate">${c.name}</h4>
                                                                                                        <p class="text-[9px] text-slate-400 font-bold mt-0.5">${c.phone || 'No Phone Number'} • ${c.email || 'No Email Address'}</p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <i class="fas fa-arrow-right-long text-slate-200 group-hover:text-emerald-500 transition-all text-xs"></i>
                                                                                            </div>
                                                                                        `;
                });
                $('#customer-results').html(html);
            }

            $(document).on('click', '.select-customer-row', function () {
                selectCustomer($(this).data('customer'));
                $('#customer-search-modal').fadeOut(100);
            });

            function selectCustomer(c) {
                selectedCustomer = c;
                $('#customer-id').val(c.id);
                $('#customer-name').val(c.name).removeClass('border-rose-300 bg-rose-50');
                $('#customer-phone').val(c.phone || '');
                $('#customer-email').val(c.email || '');
                $('#customer-address').val(c.address || '');
                $('#display-customer-name').text(c.name);
                $('#display-customer-phone').text(c.phone || 'Anonymous Customer');
                $('#customer-avatar-initial').text(c.name.charAt(0));
                $('#selected-customer-display').removeClass('hidden');
                $('#customer-form').hide();
                $('#customer-name-error').addClass('hidden');
            }

            $('#clear-customer').on('click', function () {
                selectedCustomer = null;
                $('#customer-id').val(''); $('#customer-name').val(''); $('#customer-phone').val(''); $('#customer-email').val(''); $('#customer-address').val('');
                $('#selected-customer-display').addClass('hidden'); $('#customer-form').show();
            });

            /* ──────────────── CART ENGINE ──────────────── */
            function addToCart(product) {
                let existing = cart.find(i => i.id === product.id);
                if (existing) {
                    if (existing.quantity + 1 > product.stock) {
                        Swal.fire({ icon: 'warning', text: 'Stock capacity exceeded.', background: '#f8fafc', confirmButtonColor: '#4f46e5' });
                        return;
                    }
                    existing.quantity += 1;
                } else {
                    if (product.stock_quantity < 1) {
                        Swal.fire({ icon: 'error', text: 'Product out of stock.', background: '#f8fafc', confirmButtonColor: '#4f46e5' });
                        return;
                    }
                    cart.push({ id: product.id, name: product.name, barcode: product.barcode, price: parseFloat(product.selling_price), stock: product.stock_quantity, quantity: 1 });
                }
                renderCart();
            }

            function renderCart() {
                let $tbody = $('#cart-items');
                $tbody.empty();
                if (cart.length === 0) {
                    $tbody.append($('#empty-cart-row').prop('outerHTML'));
                    updateTotals(0); $('#finalize-btn').attr('disabled', true); return;
                }
                let subtotal = 0;
                cart.forEach((item, index) => {
                    let lineTotal = item.price * item.quantity; subtotal += lineTotal;
                    $tbody.append(`
                                                        <tr class="hover:bg-slate-50/50 transition-all">
                                                            <td class="px-6 py-4">
                                                                <div class="flex items-center gap-4">
                                                                    <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 shrink-0 border border-slate-100"><i class="fas fa-cube text-xs"></i></div>
                                                                    <div class="min-w-0">
                                                                        <p class="text-xs font-bold text-slate-800 leading-none truncate">${item.name}</p>
                                                                        <p class="text-[9px] font-bold text-slate-400 mt-1.5 uppercase tracking-widest">${item.barcode}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-4 text-xs font-bold text-slate-600">${CURRENCY}${item.price.toFixed(2)}</td>
                                                            <td class="px-4 py-4 text-center">
                                                                <div class="flex items-center justify-center gap-1 bg-white border border-slate-200 rounded-xl p-1 w-fit mx-auto shadow-sm">
                                                                    <button class="h-7 w-7 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-400 hover:text-indigo-600 transition-all decrease-qty" data-index="${index}"><i class="fas fa-minus text-[8px]"></i></button>
                                                                    <input type="number" class="w-10 text-center text-xs font-bold text-slate-800 border-none focus:ring-0 p-0 qty-input" data-index="${index}" value="${item.quantity}" min="1">
                                                                    <button class="h-7 w-7 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-400 hover:text-indigo-600 transition-all increase-qty" data-index="${index}"><i class="fas fa-plus text-[8px]"></i></button>
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-4 text-xs font-black text-indigo-600">${CURRENCY}${lineTotal.toFixed(2)}</td>
                                                            <td class="px-6 py-4 text-right">
                                                                <button class="h-9 w-9 flex items-center justify-center rounded-lg text-rose-500 hover:bg-rose-50 transition-all remove-item" data-index="${index}">
                                                                    <i class="fas fa-trash-can text-xs"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    `);
                });
                updateTotals(subtotal); $('#finalize-btn').attr('disabled', false);
            }

            function updateTotals(subtotal) {
                let tax = subtotal * TAX_RATE; let grand = subtotal + tax;
                $('#summary-subtotal').text(CURRENCY + subtotal.toFixed(2));
                $('#summary-tax').text(CURRENCY + tax.toFixed(2));
                $('#summary-total').text(CURRENCY + grand.toFixed(2));
            }

            $(document).on('change', '.qty-input', function () {
                let i = $(this).data('index');
                let newQty = parseInt($(this).val()) || 1;
                if (newQty < 1) newQty = 1;
                if (newQty > cart[i].stock) {
                    Swal.fire({ icon: 'warning', text: 'Stock limit reached.', toast: true, position: 'top-end', timer: 2000, showConfirmButton: false });
                    newQty = cart[i].stock;
                }
                cart[i].quantity = newQty;
                renderCart();
            });

            $(document).on('click', '.increase-qty', function () {
                let i = $(this).data('index');
                if (cart[i].quantity + 1 > cart[i].stock) {
                    Swal.fire({ icon: 'warning', text: 'Stock limit reached.', toast: true, position: 'top-end', timer: 2000, showConfirmButton: false });
                    return;
                }
                cart[i].quantity += 1; renderCart();
            });

            $(document).on('click', '.decrease-qty', function () {
                let i = $(this).data('index'); if (cart[i].quantity > 1) { cart[i].quantity -= 1; renderCart(); }
            });

            $(document).on('click', '.remove-item', function () {
                let idx = $(this).data('index');
                Swal.fire({ title: 'Remove Item?', text: "Are you sure you want to remove this item from your cart?", icon: 'question', showCancelButton: true, confirmButtonColor: '#4f46e5', cancelButtonColor: '#f43f5e', confirmButtonText: 'Yes, Remove', background: '#f8fafc' }).then((r) => { if (r.isConfirmed) { cart.splice(idx, 1); renderCart(); } });
            });

            $('#clear-cart-btn').on('click', function () {
                Swal.fire({ title: 'Empty Cart?', text: "Are you sure you want to remove all items from your cart?", icon: 'warning', showCancelButton: true, confirmButtonColor: '#f43f5e', confirmButtonText: 'Empty Cart', background: '#f8fafc' }).then((r) => { if (r.isConfirmed) { cart = []; renderCart(); } });
            });

            /* ──────────────── SETTLEMENT ──────────────── */
            $('#finalize-btn').on('click', function () {
                if (!$('#customer-id').val() && !$('#customer-name').val()) {
                    $('#customer-name').addClass('border-rose-400 bg-rose-50').focus();
                    $('#customer-name-error').removeClass('hidden');
                    return;
                }
                let subtotal = 0; cart.forEach(i => subtotal += i.price * i.quantity);
                let tax = subtotal * TAX_RATE; let grand = subtotal + tax;
                $('#modal-items-list').html(cart.map(i => `<div class="flex justify-between items-center bg-white/5 p-3 rounded-xl border border-white/5"><div class="min-w-0"><span class="text-[11px] font-bold text-white leading-none block truncate">${i.name}</span><span class="text-[9px] font-bold text-indigo-200 uppercase mt-1 opacity-60">Vol: ${i.quantity}</span></div><span class="font-bold text-sm text-white">${CURRENCY}${(i.price * i.quantity).toFixed(2)}</span></div>`).join(''));
                $('#modal-subtotal-display').text(CURRENCY + subtotal.toFixed(2));
                $('#modal-tax-display').text(CURRENCY + tax.toFixed(2));
                $('#modal-total-display').text(CURRENCY + grand.toFixed(2));
                $('#paid_amount_input').val(grand.toFixed(2)).trigger('input');
                $('#finalizeModal').fadeIn(200).find('input#paid_amount_input').focus().select();
            });

            $('#close-finalize-btn').on('click', () => $('#finalizeModal').fadeOut(150));

            $('#paid_amount_input').on('input', function () {
                let total = parseFloat($('#modal-total-display').text().replace(CURRENCY, '').replace(/,/g, '')) || 0;
                let paid = parseFloat($(this).val()) || 0; let diff = paid - total;
                if (diff >= 0) { $('#due-amount-display').text(CURRENCY + diff.toFixed(2)).removeClass('text-rose-400').addClass('text-emerald-400'); $('#due-amount-header').text('Change Due').removeClass('text-rose-400'); }
                else { $('#due-amount-display').text(CURRENCY + Math.abs(diff).toFixed(2)).removeClass('text-emerald-400').addClass('text-rose-400'); $('#due-amount-header').text('Amount Owed').addClass('text-rose-400'); }
            });

            $('#confirm-sale-btn').on('click', function () {
                let $btn = $(this);
                let subtotal = 0; cart.forEach(i => subtotal += i.price * i.quantity);
                let tax = subtotal * TAX_RATE; let grand = subtotal + tax;
                let paid = parseFloat($('#paid_amount_input').val()) || 0;
                let payload = { customer_data: { id: $('#customer-id').val(), name: $('#customer-name').val(), phone: $('#customer-phone').val(), email: $('#customer-email').val(), address: $('#customer-address').val() }, total_amount: subtotal, tax_amount: tax, grand_total: grand, paid_amount: paid, due_amount: Math.max(0, grand - paid), payment_method: $('input[name="payment_method"]:checked').val(), items: cart.map(i => ({ product_id: i.id, quantity: i.quantity, unit_price: i.price, subtotal: i.price * i.quantity })) };

                $btn.prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-3"></i> Processing Order...');
                $.ajax({
                    url: '{{ route('pos.store') }}', method: 'POST', contentType: 'application/json', data: JSON.stringify(payload),
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Order Completed', text: 'Your order has been placed successfully.', showConfirmButton: false, timer: 1200, background: '#f8fafc' });
                            setTimeout(() => window.location.href = '{{ url('/invoice') }}/' + res.sale_id, 1200);
                        } else {
                            Swal.fire({ icon: 'error', title: 'Order Error', text: res.message, background: '#f8fafc' }); $btn.prop('disabled', false).text('Place Order');
                        }
                    },
                    error: function (xhr) {
                        let msg = 'System failure during order processing.'; try { msg = JSON.parse(xhr.responseText).message || msg; } catch (e) { }
                        Swal.fire({ icon: 'error', title: 'Order Failed', text: msg, background: '#f8fafc' }); $btn.prop('disabled', false).text('Place Order');
                    }
                });
            });

            $(document).on('keydown', e => { if (e.altKey && e.which === 80) { e.preventDefault(); $('#product-search').focus(); } });
        });
    </script>
@endpush