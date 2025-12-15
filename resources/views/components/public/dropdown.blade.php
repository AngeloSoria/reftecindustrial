@props([
    'label' => null,
])

<div {{ $attributes->except(['name', 'id', 'title', 'required', 'multiple', 'class'])->class('relative') }}>
    @if ($label)
        <p class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </p>
    @endif

    <div class="relative">
        <select
            {{ $attributes->merge([
                'class' => 'w-full font-medium px-4 py-2 appearance-none rounded-sm bg-brand-primary-950 hover:bg-brand-primary-800 active:bg-brand-primary-800 text-white'
            ]) }}
        >
            @if ($placeholder ?? false)
                <option disabled selected class="text-gray-500">
                    {{ $placeholder }}
                </option>
            @endif

            {{ $slot }}
        </select>

        @svg('fluentui-chevron-down-12', 'w-4 h-4 text-white absolute top-1/2 right-3 -translate-y-1/2 pointer-events-none')
    </div>
</div>
