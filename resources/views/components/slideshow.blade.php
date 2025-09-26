@props([
    'images' => [
        ['url' => asset('images/vilter_logo.png'), 'alt' => 'Nope', 'caption' => 'Caption here'],
        ['url' => asset('images/res_16x9.png'), 'alt' => 'Nope', 'caption' => 'Caption here'],
        ['url' => asset('images/bulan.jpg'), 'alt' => 'eqeq', 'caption' => 'Caption here'],
    ],
    'aspectRatio' => '16/9',
    'autoPlay' => false,
    'interval' => 4000,
    'size' => 'max-w-3xl', // ✅ new prop (default large width)
])

@php
    $normalized = collect($images)->map(function($img){
        if (is_string($img)) return ['url' => $img, 'alt' => '', 'caption' => ''];
        return [
            'url' => $img['url'] ?? ($img['src'] ?? ''),
            'alt' => $img['alt'] ?? '',
            'caption' => $img['caption'] ?? '',
        ];
    })->all();
@endphp

<div
    x-data="{
        slides: @js($normalized),
        idx: 0,
        playing: @js($autoPlay ? true : false),
        start() { if (this.playing) this._timer = setInterval(() => this.next(), @js($interval)); },
        stop() { clearInterval(this._timer); this._timer = null; },
        go(i){ this.idx = (i + this.slides.length) % this.slides.length; },
        next(){ this.idx = (this.idx + 1) % this.slides.length; },
        prev(){ this.idx = (this.idx - 1 + this.slides.length) % this.slides.length; }
    }"
    x-init="if (playing) start(); $watch('playing', value => value ? start() : stop())"
    class="relative w-full {{ $size }} border bg-white"
>
    <!-- Slideshow container -->
    <div class="relative w-full overflow-hidden rounded"
        style="padding-top: calc(100% / ({{ explode('/', $aspectRatio)[0] }} / {{ explode('/', $aspectRatio)[1] }}));">

        <template x-for="(slide, i) in slides" :key="i">
            <div
                x-show="i === idx"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="absolute inset-0 flex items-center justify-center"
            >
                <img :src="slide.url" :alt="slide.alt" class="object-cover w-full h-full" />
                <div x-show="slide.caption" class="absolute bottom-4 left-4 right-4 bg-black/40 text-white text-sm p-2 rounded">
                    <span x-text="slide.caption"></span>
                </div>
            </div>
        </template>

        <!-- Prev / Next -->
        <button @click="prev()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

    <!-- Indicators -->
    <div class="mt-3 flex items-center justify-center gap-2">
        <template x-for="(slide, i) in slides" :key="i">
            <button
                @click="go(i)"
                :class="{'w-8 bg-blue-600': i === idx, 'w-4 bg-gray-300': i !== idx}"
                class="h-2 rounded-full transition-all duration-150"
                :aria-current="i === idx"
                :aria-label="`Go to slide ${i+1}`"
            ></button>
        </template>
    </div>
</div>
