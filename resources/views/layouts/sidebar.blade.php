<!-- ═════════════════════ ADVANCED POS SIDEBAR ═════════════════════ -->
<div id="sidebar"
    class="sidebar fixed inset-y-0 left-0 z-40 bg-gradient-to-b from-[#352BA1] to-[#2A2282] text-slate-300 shadow-2xl lg:translate-x-0 overflow-hidden border-r border-white/5 transition-all duration-300 ease-in-out">

    <div class="flex h-full flex-col px-4 py-8">
        <!-- Close Button (Mobile Only) -->
        <button onclick="closeSidebar()"
            class="absolute top-6 right-6 lg:hidden h-10 w-10 flex items-center justify-center rounded-xl bg-white/10 text-slate-400 hover:text-white transition-all">
            <i class="fas fa-times text-xl"></i>
        </button>

        <!-- Brand Logo & Identity -->
        <div class="px-3 mb-5">
            <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('cashier.dashboard') }}"
                class="flex items-center gap-4 group transition-all">
                @if (isset($settings['site_logo']))
                    <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                        class="sidebar-icon h-11 w-11 min-w-11 rounded-2xl object-contain shadow-xl ring-2 ring-white/10 group-hover:ring-white/30 transition-all"
                        alt="Logo">
                @else
                    <div
                        class="sidebar-icon flex h-11 w-11 min-w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-all">
                        <i class="fas fa-bolt text-white text-lg"></i>
                    </div>
                @endif
                <div class="sidebar-text">
                    <span
                        class="block text-2xl font-black text-white tracking-tighter leading-none truncate transition-colors">{{ $settings['shop_name'] ?? 'TERMINAL' }}</span>
                    <span class="block text-[9px] font-black text-white/40 uppercase tracking-[0.3em] mt-2">Enterprise
                        Node</span>
                </div>
            </a>
        </div>

        <!-- Navigation Matrix -->
        <nav class="flex-1 space-y-5 overflow-y-auto px-1 custom-scrollbar scroll-smooth">

            <!-- Category: Command & Control -->
            <div>
                <span
                    class="sidebar-category-label sidebar-text px-4 text-[10px] font-black uppercase tracking-[0.25em] text-white/30 block mb-5">Command</span>
                <ul class="space-y-2">
                    @if (auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                    <i
                                        class="sidebar-icon fas fa-chart-pie {{ request()->routeIs('dashboard') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                                </div>
                                <span class="sidebar-text">Global Dashboard</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('cashier.dashboard') }}"
                                class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('cashier.dashboard') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                    <i
                                        class="sidebar-icon fas fa-gauge-high {{ request()->routeIs('cashier.dashboard') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                                </div>
                                <span class="sidebar-text">My Terminal</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('pos.index') }}"
                            class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('pos.*') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                            <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                <i
                                    class="sidebar-icon fas fa-cash-register {{ request()->routeIs('pos.*') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                            </div>
                            <span class="sidebar-text">Sales Terminal</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Category: Repositories & Resources (Staff can now see Products/Customers) -->
            <div>
                <span
                    class="sidebar-category-label sidebar-text px-4 text-[10px] font-black uppercase tracking-[0.25em] text-white/30 block mb-3">Repository</span>
                <ul class="space-y-2">
                    <li class="nav-item">
                        <button type="button"
                            class="sidebar-dropdown-toggle group w-full flex items-center justify-between rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('products.*') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                            <div class="flex items-center gap-4">
                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                    <i
                                        class="sidebar-icon fas fa-box {{ request()->routeIs('products.*') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                                </div>
                                <span class="sidebar-text">Products</span>
                            </div>
                            <i
                                class="fas fa-chevron-down text-[10px] sidebar-text opacity-40 transition-transform dropdown-arrow {{ request()->routeIs('products.*') ? 'rotate-180' : '' }}"></i>
                        </button>
                        <ul
                            class="sidebar-dropdown-menu mt-2 space-y-1 overflow-hidden transition-all duration-300 {{ request()->routeIs('products.*') ? 'block' : 'hidden' }}">
                            <li>
                                <a href="{{ route('products.index') }}"
                                    class="flex items-center gap-3 rounded-xl px-4 py-2 text-xs font-semibold pl-13 transition-all {{ request()->routeIs('products.index') ? 'text-white bg-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                                    <i
                                        class="fas fa-circle text-[6px] {{ request()->routeIs('products.index') ? 'text-indigo-400' : 'text-slate-600' }}"></i>
                                    List Products
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('products.barcodes.print') }}" target="_blank"
                                    class="flex items-center gap-3 rounded-xl px-4 py-2 text-xs font-semibold pl-13 transition-all {{ request()->routeIs('products.barcodes.print') ? 'text-white bg-white/5' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                                    <i
                                        class="fas fa-circle text-[6px] {{ request()->routeIs('products.barcodes.print') ? 'text-indigo-400' : 'text-slate-600' }}"></i>
                                    Barcode Generator
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('customers.index') }}"
                            class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('customers.*') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                            <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                <i
                                    class="sidebar-icon fas fa-user-group {{ request()->routeIs('customers.*') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                            </div>
                            <span class="sidebar-text">Customers</span>
                        </a>
                    </li>
                    @if (auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('categories.index') }}"
                                class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('categories.*') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                    <i
                                        class="sidebar-icon fas fa-tags {{ request()->routeIs('categories.*') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                                </div>
                                <span class="sidebar-text">Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('suppliers.index') }}"
                                class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('suppliers.*') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                    <i
                                        class="sidebar-icon fas fa-truck-ramp-box {{ request()->routeIs('suppliers.*') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                                </div>
                                <span class="sidebar-text">Supplier Nexus</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Category: Telemetry & Intelligence (Staff can now see Reports) -->
            <div>
                <span
                    class="sidebar-category-label sidebar-text px-4 text-[10px] font-black uppercase tracking-[0.25em] text-white/30 block mb-3">Intelligence</span>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('reports.sales') }}"
                            class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('reports.sales') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                            <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                <i
                                    class="sidebar-icon fas fa-file-invoice {{ request()->routeIs('reports.sales') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                            </div>
                            <span class="sidebar-text">Sales Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.top-products') }}"
                            class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('reports.top-products') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                            <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                <i
                                    class="sidebar-icon fas fa-trophy {{ request()->routeIs('reports.top-products') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                            </div>
                            <span class="sidebar-text">Top sale Product</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.inventory') }}"
                            class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('reports.inventory') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                            <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                <i
                                    class="sidebar-icon fas fa-warehouse {{ request()->routeIs('reports.inventory') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                            </div>
                            <span class="sidebar-text">Inventory Reports</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Category: Administration (Admin Only) -->
            @if (auth()->user()->isAdmin())
                <div>
                    <span
                        class="sidebar-category-label sidebar-text px-4 text-[10px] font-black uppercase tracking-[0.25em] text-white/30 block mb-5">Administration</span>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('users.index') }}"
                                class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('users.*') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                    <i
                                        class="sidebar-icon fas fa-user-shield {{ request()->routeIs('users.*') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                                </div>
                                <span class="sidebar-text">Users Management</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('audit-logs.index') }}"
                                class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('audit-logs.*') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                    <i
                                        class="sidebar-icon fas fa-fingerprint {{ request()->routeIs('audit-logs.*') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                                </div>
                                <span class="sidebar-text">Audit Logs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.index') }}"
                                class="group flex items-center gap-4 rounded-2xl px-4 py-2 text-sm font-bold transition-all {{ request()->routeIs('settings.*') ? 'bg-white/10 text-white shadow-xl ring-1 ring-white/20' : 'hover:bg-white/5 hover:text-white' }}">
                                <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                    <i
                                        class="sidebar-icon fas fa-sliders {{ request()->routeIs('settings.*') ? 'opacity-100' : 'opacity-40 group-hover:opacity-100' }} transition-opacity"></i>
                                </div>
                                <span class="sidebar-text">General Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif

        </nav>

        <!-- Identity Block -->
        <div class="mt-auto pt-8 border-t border-white/5">
            <div
                class="flex items-center gap-3 p-3 bg-white/5 rounded-[2rem] border border-white/10 mb-6 group cursor-default">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=6366f1&color=fff"
                    class="sidebar-icon h-11 w-11 min-w-11 rounded-2xl object-cover shadow-xl group-hover:scale-110 transition-all"
                    alt="Profile">
                <div class="flex-1 overflow-hidden sidebar-text">
                    <p class="truncate text-sm font-black text-white leading-none mb-1">
                        {{ auth()->user()->name ?? 'User' }}
                    </p>
                    <div class="flex items-center gap-1.5 opacity-60">
                        <div
                            class="h-1 w-1 rounded-full {{ auth()->user()->isAdmin() ? 'bg-indigo-400' : 'bg-emerald-400' }} animate-pulse">
                        </div>
                        <p class="truncate text-[9px] font-black uppercase tracking-widest text-slate-400">
                            {{ auth()->user()->role }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="sidebar-text">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="group flex w-full items-center gap-4 rounded-2xl px-5 py-2 text-left text-xs font-black uppercase tracking-widest text-white/40 hover:bg-rose-500/10 hover:text-rose-400 transition-all active:scale-95">
                        <i
                            class="sidebar-icon fas fa-power-off opacity-30 group-hover:opacity-100 transition-opacity"></i>
                        <span>Disconnect</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    #sidebar {
        width: 300px;
    }

    .sidebar-collapsed #sidebar {
        width: 88px;
    }

    .sidebar-text {
        transition: opacity 0.2s ease;
    }

    .sidebar-collapsed .sidebar-text {
        opacity: 0;
        pointer-events: none;
    }

    .sidebar-collapsed .sidebar-category-label {
        visibility: hidden;
    }
</style>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownToggles = document.querySelectorAll('.sidebar-dropdown-toggle');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const menu = this.nextElementSibling;
                    const arrow = this.querySelector('.dropdown-arrow');

                    // Toggle current dropdown
                    if (menu.classList.contains('hidden')) {
                        menu.classList.remove('hidden');
                        menu.classList.add('block');
                        arrow.classList.add('rotate-180');
                    } else {
                        menu.classList.remove('block');
                        menu.classList.add('hidden');
                        arrow.classList.remove('rotate-180');
                    }
                });
            });
        });
    </script>
@endpush