@php
    switch ($modalPosition) {
        case 'top-left':
            $flex_default = 'items-start justify-start';
            break;
        case 'top-right':
            $flex_default = 'items-start justify-end';
            break;
        case 'top-center':
            $flex_default = 'items-start justify-center';
            break;
        case 'bottom-left':
            $flex_default = 'items-end justify-start';
            break;
        case 'bottom-right':
            $flex_default = 'items-end justify-end';
            break;
        case 'bottom-center':
            $flex_default = 'items-end justify-center';
            break;
        default:
            $flex_default = 'items-center justify-center';
            break;
    }
@endphp

<section x-data="{ open: @entangle('open').live }" x-show="open" x-cloak
    class="z-[300] bg-black/50 backdrop-blur-xs fixed inset-0 w-full h-screen p-4 flex font-inter {{ $flex_default }}"
    @keydown.escape.window="{{ $enableCloseOnEscKeyPressed ? '$wire.closeModal()' : '' }}"
    @click.self="{{ $enableCloseOnOutsideClick ? '$wire.closeModal()' : '' }}">

    <div x-show="open" x-transition x-cloak
        class="p-4 bg-white rounded outline-1 outline-accent-darkslategray-400 w-full h-fit max-w-{{ $modalMaxWidth }} max-h-[95%] overflow-x-hidden overflow-y-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-300/50 pb-2 mb-4">
            <h1 class="text-xl font-medium">{{ $titleHeaderText }}</h1>
            <button wire:click="closeModal" class="p-1 rounded-full text-black/50 hover:text-black">
                @svg('zondicon-close', 'w-4 h-4')
            </button>
        </div>

        {{-- Body --}}
    </div>
</section>
