<div class="flex items-center gap-1 text-white bg-brand-primary-950 rounded-sm px-2 py-1">
    {{-- icon --}}
    <div class="p-1">
        <x-zondicon-search class="w-4 h-4" />
    </div>
    <input type="text" {{ $attributes->merge(['class' => 'w-full bg-brand-primary-950/80 rounded-sm px-4 py-1 focus:outline-1 outline-white/30 outline-offset-2', 'placeholder' => 'Search...']) }}>
</div>
