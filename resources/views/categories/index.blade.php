@extends('layouts.app')

@section('header', 'Category Management')

@section('content')
    <div class="flex flex-col gap-8">
        <div class="flex justify-between items-center bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Product Categories</h2>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Manage your category hierarchy
                </p>
            </div>
            <div class="flex gap-3">
                <button
                    class="h-12 w-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 transition-all">
                    <i class="fas fa-search text-sm"></i>
                </button>
                <button
                    class="h-12 w-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-100 transition-all">
                    <i class="fas fa-filter text-sm"></i>
                </button>
                <button onclick="openModal()"
                    class="flex items-center gap-2 h-12 px-6 rounded-2xl bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all">
                    <i class="fas fa-plus opacity-70"></i> Add Category
                </button>
            </div>
        </div>

        <!-- Categories List -->
        <div class="rounded-[2.5rem] bg-white shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">
                                Category</th>
                            <th class="px-6 py-5 text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">Type
                            </th>
                            <th class="px-6 py-5 text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">
                                Products</th>
                            <th class="px-6 py-5 text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">
                                Status</th>
                            <th
                                class="px-8 py-5 text-right text-[10px] font-extrabold uppercase tracking-[0.2em] text-slate-400">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($categories as $category)
                            <!-- Parent Category -->
                            <tr class="group hover:bg-slate-50/30 transition-all duration-300">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-14 w-14 rounded-2xl bg-white border border-slate-100 overflow-hidden shadow-sm">
                                            <img src="{{ $category->image_url }}"
                                                class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                alt="{{ $category->name }}" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-extrabold text-slate-900 mb-0.5">{{ $category->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                                {{ $category->slug }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 border-l-4 border-emerald-500/0 group-hover:border-emerald-500/10">
                                    <span
                                        class="inline-flex items-center rounded-xl bg-emerald-50 px-3 py-1.5 text-[10px] font-extrabold text-emerald-600 border border-emerald-100/50">
                                        <i class="fas fa-layer-group mr-1.5 opacity-60"></i> Main Category
                                    </span>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-extrabold text-slate-700">{{ $category->products_count }}</span>
                                        <span
                                            class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Items</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[10px] font-extrabold {{ $category->status ? 'text-emerald-600 bg-emerald-50' : 'text-slate-400 bg-slate-100' }}">
                                        <span
                                            class="h-1.5 w-1.5 rounded-full {{ $category->status ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-slate-300' }}"></span>
                                        {{ $category->status ? 'ACTIVE' : 'HIDDEN' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right space-x-1">
                                    <button type="button"
                                        class="edit-category inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:border-indigo-100 hover:bg-indigo-50 hover:text-indigo-600 shadow-sm transition-all"
                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                        data-description="{{ $category->description }}" data-parent="{{ $category->parent_id }}"
                                        data-status="{{ $category->status ? 1 : 0 }}" data-image="{{ $category->image_url }}"
                                        aria-label="Edit category">
                                        <i class="fas fa-pen-nib text-[10px]"></i>
                                    </button>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:border-rose-100 hover:bg-rose-50 hover:text-rose-500 shadow-sm transition-all"
                                            onclick="return confirm('Are you sure you want to delete this category? This will also affect subcategories.')">
                                            <i class="fas fa-trash-alt text-[10px]"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Subcategories -->
                            @foreach($category->subcategories as $child)
                                <tr class="group hover:bg-slate-50/50 transition-all duration-300 bg-slate-50/20">
                                    <td class="px-8 py-4 pl-16">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-10 w-10 rounded-xl bg-white border border-slate-100 overflow-hidden shadow-sm relative">
                                                <div
                                                    class="absolute inset-0 bg-slate-900/5 group-hover:bg-transparent transition-all z-10">
                                                </div>
                                                <img src="{{ $child->image_url }}"
                                                    class="h-full w-full object-cover opacity-80 group-hover:opacity-100 transition-opacity"
                                                    alt="{{ $child->name }}" />
                                            </div>
                                            <div>
                                                <p class="text-xs font-extrabold text-slate-800 mb-0.5"><i
                                                        class="fas fa-level-up-alt rotate-90 mr-2 text-indigo-300"></i>{{ $child->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center rounded-lg bg-indigo-50/50 px-2 py-1 text-[9px] font-extrabold text-indigo-500 border border-indigo-100/30">
                                            <i class="fas fa-sitemap mr-1 opacity-60"></i> Subcategory
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-xs font-extrabold text-slate-600">{{ $child->products_count }}</span>
                                            <span
                                                class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Items</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[9px] font-extrabold {{ $child->status ? 'text-emerald-500 bg-emerald-50/50' : 'text-slate-400 bg-slate-100/50' }}">
                                            <span
                                                class="h-1 w-1 rounded-full {{ $child->status ? 'bg-emerald-400' : 'bg-slate-300' }}"></span>
                                            {{ $child->status ? 'ACTIVE' : 'HIDDEN' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-right space-x-1">
                                        <button type="button"
                                            class="edit-category inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white border border-slate-100 text-slate-400 hover:border-indigo-100 hover:bg-indigo-50 hover:text-indigo-600 shadow-sm transition-all"
                                            data-id="{{ $child->id }}" data-name="{{ $child->name }}"
                                            data-description="{{ $child->description }}" data-parent="{{ $child->parent_id }}"
                                            data-status="{{ $child->status ? 1 : 0 }}" data-image="{{ $child->image_url }}"
                                            aria-label="Edit subcategory">
                                            <i class="fas fa-pen-nib text-[9px]"></i>
                                        </button>
                                        <form action="{{ route('categories.destroy', $child) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white border border-slate-100 text-slate-400 hover:border-rose-100 hover:bg-rose-50 hover:text-rose-500 shadow-sm transition-all"
                                                onclick="return confirm('Are you sure you want to delete this subcategory?')">
                                                <i class="fas fa-trash-alt text-[9px]"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="py-32 text-center bg-slate-50/20">
                                    <div class="flex flex-col items-center">
                                        <div class="h-24 w-24 rounded-full bg-slate-100 flex items-center justify-center mb-6">
                                            <i class="fas fa-folder-open text-3xl text-slate-300"></i>
                                        </div>
                                        <h3 class="text-lg font-extrabold text-slate-900">No categories found</h3>
                                        <p class="text-sm font-medium text-slate-400 max-w-xs mx-auto">Start by adding your
                                            first category.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="px-8 py-5 border-t border-slate-50 bg-slate-50/30">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal for Create/Edit Category -->
    <div id="category-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" aria-hidden="true"
                id="modal-backdrop"></div>

            <!-- Center modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="relative inline-block w-full px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-[2rem] shadow-2xl sm:my-8 sm:align-middle sm:max-w-xl sm:p-8 sm:w-full border border-slate-100">
                <!-- Close button -->
                <div class="absolute top-0 right-0 pt-6 pr-6">
                    <button type="button" onclick="closeModal()"
                        class="text-slate-400 bg-slate-50 rounded-xl hover:text-slate-600 hover:bg-slate-100 focus:outline-none w-10 h-10 flex items-center justify-center transition-all">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mb-8">
                    <h3 class="text-2xl font-extrabold text-slate-900" id="category-form-title">Create New Category</h3>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-1">Organize your inventory
                        effectively</p>
                </div>

                <form id="category-form" action="{{ route('categories.store') }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="category-form-method" />
                    <input type="hidden" id="category-id-input" />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Image Preview Area -->
                        <div class="space-y-2 md:col-span-2">
                            <label
                                class="block text-xs font-extrabold uppercase tracking-widest text-slate-400 ms-1">Category
                                Image</label>
                            <div class="relative group">
                                <div
                                    class="h-40 w-full rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-indigo-300 group-hover:bg-indigo-50/30">
                                    <img id="image-preview" src="{{ asset('assets/img/placeholder-image.png') }}"
                                        class="h-full w-full object-cover hidden" />
                                    <div id="upload-placeholder" class="text-center p-4">
                                        <i
                                            class="fas fa-cloud-upload-alt text-3xl text-indigo-300 mb-3 group-hover:-translate-y-1 transition-transform"></i>
                                        <p class="text-xs font-bold text-slate-600">Click to browse or drag image here</p>
                                        <p class="text-[10px] font-medium text-slate-400 mt-1">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                                <input type="file" name="image" id="category-image-input"
                                    class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" />
                            </div>
                            @error('image')
                                <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label
                                class="block text-xs font-extrabold uppercase tracking-widest text-slate-400 ms-1">Category
                                Name</label>
                            <input type="text" name="name" id="category-name-input" placeholder="e.g. Beverages" required
                                class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 focus:bg-white focus:shadow-sm transition-all" />
                            @error('name')
                                <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-extrabold uppercase tracking-widest text-slate-400 ms-1">Parent
                                Category</label>
                            <select name="parent_id" id="category-parent-input"
                                class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 focus:bg-white focus:shadow-sm transition-all appearance-none cursor-pointer">
                                <option value="">Main Category</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label
                                class="block text-xs font-extrabold uppercase tracking-widest text-slate-400 ms-1">Description</label>
                            <textarea id="category-description-input" name="description" rows="3"
                                class="w-full border-0 bg-slate-50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 focus:bg-white focus:shadow-sm transition-all placeholder:text-slate-300"
                                placeholder="Optional category details..."></textarea>
                            @error('description')
                                <p class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2 flex items-center gap-4 bg-slate-50 p-5 rounded-2xl border border-slate-100 cursor-pointer"
                            onclick="document.getElementById('category-status-input').click()">
                            <div class="flex h-6 items-center">
                                <input id="category-status-input" name="status" type="checkbox" checked value="1"
                                    class="h-6 w-6 rounded-lg border-slate-200 text-indigo-600 focus:ring-indigo-600/20 transition-all cursor-pointer">
                            </div>
                            <div class="text-sm">
                                <label for="category-status-input" class="font-bold text-slate-700 cursor-pointer">Display
                                    Category Publicly</label>
                                <p class="text-[11px] text-slate-400 font-medium mt-0.5">Visible to customers and available
                                    in point of sale</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100 flex gap-3 justify-end">
                        <button type="button" onclick="closeModal()"
                            class="px-6 py-4 rounded-2xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all w-full sm:w-auto">Cancel</button>
                        <button type="submit"
                            class="px-8 py-4 rounded-2xl bg-indigo-600 text-white text-sm font-bold shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-600/30 transition-all w-full sm:w-auto flex items-center justify-center gap-2"
                            id="category-form-submit">
                            <i class="fas fa-check"></i> Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('category-modal');
        const form = document.getElementById('category-form');

        // Reopen category modal on validation error
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', function () {
                const action = '{{ session('category_modal_action') }}';
                const id = '{{ session('category_id') }}';
                if (action === 'edit' && id) {
                    const editButton = document.querySelector(`.edit-category[data-id="${id}"]`);
                    if (editButton) {
                        editButton.click();
                        // Overwrite with old inputs so user inputs are not lost
                        document.getElementById('category-name-input').value = '{{ old('name') }}';
                        document.getElementById('category-parent-input').value = '{{ old('parent_id') }}';
                        document.getElementById('category-description-input').value = '{{ old('description') }}';
                        document.getElementById('category-status-input').checked = {{ old('status') ? 'true' : 'false' }};
                    } else {
                        openModal();
                    }
                } else {
                    openModal();
                    document.getElementById('category-name-input').value = '{{ old('name') }}';
                    document.getElementById('category-parent-input').value = '{{ old('parent_id') }}';
                    document.getElementById('category-description-input').value = '{{ old('description') }}';
                    document.getElementById('category-status-input').checked = {{ old('status') ? 'true' : 'false' }};
                }
            });
        @endif

        const formTitle = document.getElementById('category-form-title');
        const methodInput = document.getElementById('category-form-method');
        const nameInput = document.getElementById('category-name-input');
        const parentInput = document.getElementById('category-parent-input');
        const descInput = document.getElementById('category-description-input');
        const statusInput = document.getElementById('category-status-input');
        const submitButton = document.getElementById('category-form-submit');

        const imageInput = document.getElementById('category-image-input');
        const imagePreview = document.getElementById('image-preview');
        const uploadPlaceholder = document.getElementById('upload-placeholder');

        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            setTimeout(resetForm, 300); // Reset after animation
        }

        // Close modal on backdrop click
        document.getElementById('modal-backdrop').addEventListener('click', closeModal);

        // Image Preview Handler
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        function resetForm() {
            form.action = "{{ route('categories.store') }}";
            methodInput.value = 'POST';
            formTitle.textContent = 'Create New Category';
            submitButton.innerHTML = '<i class="fas fa-check"></i> Create Category';

            nameInput.value = '';
            parentInput.value = '';
            descInput.value = '';
            statusInput.checked = true;

            imagePreview.classList.add('hidden');
            imagePreview.src = '';
            uploadPlaceholder.classList.remove('hidden');
            imageInput.value = '';
        }

        document.querySelectorAll('.edit-category').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                const data = this.dataset;

                form.action = `/categories/${data.id}`;
                methodInput.value = 'PUT';

                nameInput.value = data.name;
                parentInput.value = data.parent || '';
                descInput.value = data.description || '';
                statusInput.checked = data.status == '1';

                if (data.image && !data.image.includes('placeholder')) {
                    imagePreview.src = data.image;
                    imagePreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                } else {
                    imagePreview.classList.add('hidden');
                    uploadPlaceholder.classList.remove('hidden');
                }

                formTitle.textContent = 'Update Category';
                submitButton.innerHTML = '<i class="fas fa-save"></i> Save Changes';

                openModal();
            });
        });
    </script>

@endsection