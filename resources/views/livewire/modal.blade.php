<div x-data="{ open: @entangle('open').live }" x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-cloak>
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-xl p-6 relative" @click.away="$wire.close()"
        @keydown.escape.window="$wire.close()">
        <button class="absolute top-3 right-3 text-gray-400 hover:text-gray-600" wire:click="close">
            ✕
        </button>

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
