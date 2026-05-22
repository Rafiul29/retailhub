@props(['disabled' => false, 'label' => '', 'name' => '', 'type' => 'text', 'value' => '', 'placeholder' => ''])

<div class="space-y-2">
    @if($label)
        <label for="{{ $attributes->get('id', $name) }}" class="block text-xs font-extrabold uppercase tracking-widest text-slate-400 ms-1">{{ $label }}</label>
    @endif
    
    <div class="relative group">
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $attributes->get('id', $name) }}" 
            {{ $disabled ? 'disabled' : '' }} 
            {{ $attributes->merge(['class' => 'w-full border-0 bg-slate-100/50 py-4 px-5 text-sm font-semibold rounded-2xl focus:ring-4 focus:ring-indigo-600/10 transition-all placeholder:text-slate-300 disabled:opacity-50']) }}
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
        >
    </div>

    @error($name)
        <p class="text-xs font-bold text-rose-500 ms-1">{{ $message }}</p>
    @enderror
</div>
