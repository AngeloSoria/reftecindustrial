
@php
    $buttonType = $attributes->get('button_type');
    switch ($buttonType) {
        case 'primary':
            $classes = 'bg-accent-orange-300 text-black hover:bg-accent-orange-400';
            break;
        case 'secondary':
            $classes = 'bg-brand-primary-950 text-white hover:bg-brand-primary-900';
            break;
        case 'default':
            $classes = 'bg-white hover:bg-gray-200 border';
            break;
        default:
            $classes = 'border';
            break;
    }

    $size = $attributes->get('size');
    switch ($size) {
        case 'sm':
            $buttonScale = 'scale-90 text-sm';
            break;
        case 'lg':
            $buttonScale = 'scale-105 text-lg';
            break;
        case 'xl':
            $buttonScale = 'scale-110 text-lg';
            break;
        case '2xl':
            $buttonScale = 'scale-125 text-xl';
            break;
        case 'md':
        default:
            $buttonScale = 'scale-100 text-base';
            break;
    }
@endphp

@props([
    'button_type' => null,
    'href' => null,
    'type' => 'button',
    'size' => 'md',
    'disabled' => false,
])

@if($href)
    <a
    role="button"
    href="{{ $href }}"
    class="py-2 px-4 {{ $buttonScale }} rounded shadow-sm {{ $attributes->get('class') ?? 'transition-colors cursor-pointer' }} {{ $classes }}">
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        class="flex justify-center items-center gap-2 py-2 px-4 {{ $buttonScale }} rounded {{ $attributes->get('class') ?? 'transition-colors cursor-pointer' }} {{ $classes }}
        disabled:opacity-50 disabled:cursor-not-allowed"
        {{ $attributes }}>
        {{ $slot }}
    </button>
@endif
