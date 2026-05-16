@extends('layouts.app')

@section('header', 'Dashboard Overview')

@section('content')
    <div class="flex flex-col gap-6 p-2 sm:p-0">
        <!-- Welcome Banner/Hero Segment -->
        <div
            class="relative overflow-hidden rounded-3xl bg-linear-to-r from-[#6366f1] via-[#a855f7] to-[#ec4899] p-8 text-white shadow-xl shadow-indigo-200">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="p-1.5 bg-white/20 rounded-lg backdrop-blur-md">
                            <i class="fas fa-sparkles text-sm"></i>
                        </span>
                        <h2 class="text-2xl font-extrabold tracking-tight">Welcome Back!</h2>
                    </div>
                    <p class="text-indigo-50 font-medium opacity-90">Here's what's happening with your store today.</p>
                </div>
                <a href="{{ route('pos.index') }}"
                    class="group flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3.5 text-sm font-bold text-indigo-600 transition-all hover:scale-105 active:scale-95 shadow-lg shadow-black/5">
                    <i class="fas fa-shopping-cart text-xs transition-transform group-hover:rotate-12"></i>
                    New Sale
                </a>
            </div>
            <!-- Decorative Elements -->
            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute -left-10 -bottom-10 h-40 w-40 rounded-full bg-indigo-500/20 blur-3xl"></div>
        </div>

        <!-- Key Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Revenue Card -->
            <div
                class="group relative overflow-hidden rounded-4xl bg-white p-6 shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:shadow-indigo-500/10">
                <div class="absolute left-0 top-0 h-full w-1 bg-emerald-500"></div>
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="h-12 w-12 flex items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition-transform group-hover:scale-110">
                        {{-- <i class="fas fa-dollar-sign text-xl"></i> --}}
                         {{ $settings['currency_symbol'] ?? '$' }}
                    </div>
                    <div class="text-right">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Today's Revenue</p>
                        <h3 class="text-2xl font-black text-slate-900">
                            {{ $settings['currency_symbol'] ?? '$' }}{{ number_format($stats['revenue_today'], 0) }}</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-slate-50">
                    <span
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $stats['transactions_today'] }}
                        transactions</span>
                </div>
            </div>

            <!-- Sales Count Card -->
            <div
                class="group relative overflow-hidden rounded-4xl bg-white p-6 shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:shadow-indigo-500/10">
                <div class="absolute left-0 top-0 h-full w-1 bg-blue-500"></div>
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="h-12 w-12 flex items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-transform group-hover:scale-110">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Sales</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ number_format($stats['total_sales_count']) }}</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-slate-50">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Avg:
                        {{ $settings['currency_symbol'] ?? '$' }}{{ number_format($stats['total_sales_avg'], 0) }}</span>
                </div>
            </div>

            <!-- Products Card -->
            <div
                class="group relative overflow-hidden rounded-4xl bg-white p-6 shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:shadow-indigo-500/10">
                <div class="absolute left-0 top-0 h-full w-1 bg-purple-500"></div>
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="h-12 w-12 flex items-center justify-center rounded-2xl bg-purple-50 text-purple-600 transition-transform group-hover:scale-110">
                        <i class="fas fa-box text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Products</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ number_format($stats['total_products']) }}</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-slate-50">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Stock:
                        {{ number_format($stats['total_stock']) }} units</span>
                </div>
            </div>

            <!-- Stock Value Card -->
            <div
                class="group relative overflow-hidden rounded-4xl bg-white p-6 shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:shadow-indigo-500/10">
                <div class="absolute left-0 top-0 h-full w-1 bg-orange-500"></div>
                <div class="flex items-start justify-between mb-4">
                    <div
                        class="h-12 w-12 flex items-center justify-center rounded-2xl bg-orange-50 text-orange-600 transition-transform group-hover:scale-110">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Stock Value</p>
                        <h3 class="text-2xl font-black text-slate-900">
                            {{ $settings['currency_symbol'] ?? '$' }}{{ number_format($stats['stock_value'], 0) }}</h3>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-slate-50">
                    <span
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $stats['total_categories'] }}
                        categories</span>
                </div>
            </div>
        </div>

        <!-- Insights Row: Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Trend Chart -->
            <div class="rounded-4xl bg-white p-8 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h4 class="text-lg font-extrabold text-slate-900">Revenue Trend</h4>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Last 7 days</p>
                    </div>
                    <a href="{{ route('reports.sales') }}"
                        class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        View All <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                <div class="h-64 relative">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
            </div>

            <!-- Sales Volume Chart -->
            <div class="rounded-4xl bg-white p-8 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h4 class="text-lg font-extrabold text-slate-900">Sales Volume</h4>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Last 7 days</p>
                    </div>
                    <a href="{{ route('reports.sales') }}"
                        class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        View All <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                <div class="h-64 relative">
                    <canvas id="salesVolumeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Secondary Data Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Products List -->
            <div class="rounded-4xl bg-white p-8 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h4 class="text-lg font-extrabold text-slate-900">Top Products</h4>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">By revenue</p>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        View All <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($topProducts as $product)
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl bg-slate-50/50 border border-slate-50 transition-colors hover:bg-white hover:shadow-lg hover:shadow-slate-200/50">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 font-bold">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900">{{ $product->name }}</p>
                                    <span
                                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->category->name }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-indigo-600">
                                    {{ $settings['currency_symbol'] ?? '$' }}{{ number_format($product->total_revenue, 2) }}</p>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ number_format($product->stock_quantity) }}
                                    in stock</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <p class="text-sm font-bold text-slate-400 opacity-60">No sales data available</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="rounded-4xl bg-white p-8 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h4 class="text-lg font-extrabold text-slate-900">Low Stock Alert</h4>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ $lowStockProducts->count() }} items</p>
                    </div>
                    <a href="{{ route('products.index', ['filter' => 'low_stock']) }}"
                        class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        View All <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($lowStockProducts->take(5) as $product)
                        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 flex items-center gap-4">
                            <div
                                class="h-10 w-10 flex items-center justify-center rounded-xl bg-white text-rose-500 shadow-sm shrink-0">
                                <i class="fas fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">{{ $product->name }}</p>
                                <p class="text-xs font-bold text-rose-600">Stock: {{ $product->stock_quantity }} <span
                                        class="text-slate-400 opacity-60 mx-1">|</span> Min: {{ $product->reorder_level }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <p class="text-sm font-bold text-slate-400 opacity-60">No low stock items</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Navigation Icons -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pb-6">
            <a href="{{ route('reports.sales') }}"
                class="group flex flex-col items-center justify-center gap-4 p-8 rounded-[2.5rem] bg-indigo-600 text-white shadow-xl shadow-indigo-200 transition-all hover:scale-[1.03] active:scale-95">
                <div
                    class="h-16 w-16 flex items-center justify-center rounded-2xl bg-white/20 backdrop-blur-md transition-transform group-hover:rotate-12">
                    <i class="fas fa-cart-shopping text-3xl"></i>
                </div>
                <span class="text-lg font-extrabold tracking-tight">Sale</span>
            </a>

            <a href="{{ route('products.index') }}"
                class="group flex flex-col items-center justify-center gap-4 p-8 rounded-[2.5rem] bg-blue-500 text-white shadow-xl shadow-blue-200 transition-all hover:scale-[1.03] active:scale-95">
                <div
                    class="h-16 w-16 flex items-center justify-center rounded-2xl bg-white/20 backdrop-blur-md transition-transform group-hover:rotate-12">
                    <i class="fas fa-cube text-3xl"></i>
                </div>
                <span class="text-lg font-extrabold tracking-tight">Product</span>
            </a>

            <a href="{{ route('purchases.index') }}"
                class="group flex flex-col items-center justify-center gap-4 p-8 rounded-[2.5rem] bg-emerald-500 text-white shadow-xl shadow-emerald-200 transition-all hover:scale-[1.03] active:scale-95">
                <div
                    class="h-16 w-16 flex items-center justify-center rounded-2xl bg-white/20 backdrop-blur-md transition-transform group-hover:rotate-12">
                    <i class="fas fa-wave-square text-3xl"></i>
                </div>
                <span class="text-lg font-extrabold tracking-tight">Stock</span>
            </a>

            <a href="{{ route('reports.sales') }}"
                class="group flex flex-col items-center justify-center gap-4 p-8 rounded-[2.5rem] bg-orange-600 text-white shadow-xl shadow-orange-200 transition-all hover:scale-[1.03] active:scale-95">
                <div
                    class="h-16 w-16 flex items-center justify-center rounded-2xl bg-white/20 backdrop-blur-md transition-transform group-hover:rotate-12">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
                <span class="text-lg font-extrabold tracking-tight">Reports</span>
            </a>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(235, 241, 250, 0.4)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 10, weight: '600' },
                        color: '#94a3b8'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 10, weight: '600' },
                        color: '#94a3b8'
                    }
                }
            }
        };

        // Revenue Trend Chart
        const ctxRevenue = document.getElementById('revenueTrendChart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Revenue',
                    data: @json($chartData['revenue']),
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: chartConfig
        });

        // Sales Volume Chart
        const ctxVolume = document.getElementById('salesVolumeChart').getContext('2d');
        new Chart(ctxVolume, {
            type: 'bar',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Transactions',
                    data: @json($chartData['volume']),
                    backgroundColor: '#a855f7',
                    borderRadius: 8,
                    barThickness: 20
                }]
            },
            options: chartConfig
        });
    </script>
@endpush