<div class="relative">
    @if ($label ?? false)
        <p class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</p>
    @endif

    <div class="relative">
        <select
        
            @if($id ?? false) id="{{ $id }}" @endif
            @if($name ?? false) name="{{ $name }}" @endif
            @if($title ?? false) title="{{ $title }}" @endif
            @if($required ?? false) required @endif
            @if($multiple ?? false) multiple @endif
            
            class="min-w-[150px] md:min-w-[200px] font-medium border px-4 py-2 appearance-none {{ $attributes->get('class') }} bg-brand-primary text-white">
            
            @if ($placeholder ?? false)
                <option disabled selected class="text-gray-500">{{ $placeholder }}</option>
            @endif

            {{ $slot }}
        </select>

        @svg('bxs-down-arrow', 'w-4 h-4 text-white absolute top-1/2 right-3 -translate-y-1/2 pointer-events-none')
    </div>
</div>
