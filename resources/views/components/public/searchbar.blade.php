@props([
    'placeholder' => 'Search...',
    'name' => null,
    'id' => 'searchbar-' . uniqid(),
])

<div class="{{ $attributes->get('class') }} flex items-center gap-1 text-white bg-brand-primary-950 rounded-sm px-2 py-1">
    {{-- icon --}}
    <div class="p-1">
        @svg('fluentui-search-12', 'w-4 h-4')
    </div>
    <input
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($name) name="{{ $name }}" @endif
        @if($id) id="{{ $id }}" @endif
        type="text"
        class="w-full bg-brand-primary-950/80 rounded-sm px-4 py-1 focus:outline-1 outline-white/30 outline-offset-2">
</div>
