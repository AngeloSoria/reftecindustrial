<div x-data="{
        open: @entangle('open').live,
        modalSize: @entangle('size').live,
        modalHeaderText: @entangle('modalHeaderText').live,
    }"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
    <div x-show="open" x-cloak x-transition @click.away="$wire.close()" @keydown.escape.window="$wire.close()"
        :class="modalSize ? `max-w-${modalSize}` : 'max-w-xl'"
        class="p-4 bg-white rounded outline-1 outline-accent-darkslategray-400 w-full h-fit max-h-[95%] overflow-x-hidden overflow-y-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-300/50 pb-2 mb-4">
            <h1 class="text-xl font-medium" x-text="modalHeaderText"></h1>
            <div class="">
                <button title="Close" wire:click="close"
                    class="p-1 rounded-full cursor-pointer text-black/50 hover:text-black outline-gray-400/25 hover:outline-1">
                    @svg('zondicon-close', 'w-4 h-4')
                </button>
            </div>
        </div>

        {{-- Dynamically load content --}}
        @if($view)
            @php
                $isLivewire = \Livewire\Livewire::isDiscoverable($view);
            @endphp

            @if($isLivewire)
                {{-- {{ dd($data) }} --}}
                @livewire($view, $data, key($view))
            @else
                @include($view, $data)
            @endif
        @else
            <p>No view loaded.</p>
        @endif

    </div>
</div>
