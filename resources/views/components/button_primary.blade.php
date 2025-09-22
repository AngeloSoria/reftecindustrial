@php
    $sizeClasses = match ($size ?? 'md') {
        'sm' => 'px-3 py-1 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-5 py-3 text-lg',
        'xl' => 'px-6 py-4 text-xl',
        default => 'px-4 py-2 text-base',
    };

    $colorClasses = match ($color ?? 'primary') {
        'primary' => 'bg-accent-yellow text-black hover:bg-yellow-400',
        'secondary' => 'bg-brand-primary text-white hover:bg-brand-dark',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        default => 'bg-accent-yellow text-black hover:bg-yellow-400',
    };
@endphp

<a href="{{ $href }}" class="inline-block {{ $attributes->get('class') }} {{ $sizeClasses }} {{ $colorClasses }}"
    role="button">
    @if ($suffixIcon ?? false)
        <span class="inline-flex items-center space-x-2">
            <span>{{ $slot }}</span>
            <i data-lucide="{{ $suffixIcon }}" class="w-4 h-4"></i>
        </span>
    @elseif($prefixIcon ?? false)
        <span class="inline-flex items-center space-x-2">
            <i data-lucide="{{ $prefixIcon }}" class="w-4 h-4"></i>
            <span>{{ $slot }}</span>
        </span>
    @else
        {{ $slot }}
    @endif
</a>
