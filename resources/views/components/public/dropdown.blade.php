@props([
    'label' => null,
])

<div class="relative {{ $attributes->get('class') }}">
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

            class="w-full font-medium px-4 py-2 appearance-none rounded-sm bg-brand-primary-950 hover:bg-brand-primary-800 active:bg-brand-primary-800 text-white">

            @if ($placeholder ?? false)
                <option disabled selected class="text-gray-500">{{ $placeholder }}</option>
            @endif

            {{ $slot }}
        </select>

        @svg('fluentui-chevron-down-12', 'w-4 h-4 text-white absolute top-1/2 right-3 -translate-y-1/2 pointer-events-none')
    </div>
</div>
