<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'images' => [
        // Placeholders if there's no image passed.
        ['url' => asset('images/reftec_logo_transparent_16x9.png'), 'alt' => 'Reftec Logo', 'caption' => 'Reftec Industrial Supply and Services Inc. Logo'],
    ],
    'aspectRatio' => '16/9',
    'autoPlay' => false,
    'interval' => 4000,
    'size' => 'max-w-3xl',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'images' => [
        // Placeholders if there's no image passed.
        ['url' => asset('images/reftec_logo_transparent_16x9.png'), 'alt' => 'Reftec Logo', 'caption' => 'Reftec Industrial Supply and Services Inc. Logo'],
    ],
    'aspectRatio' => '16/9',
    'autoPlay' => false,
    'interval' => 4000,
    'size' => 'max-w-3xl',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $normalized = collect($images)->map(function($img){
        if (is_string($img)) return ['url' => $img, 'alt' => '', 'caption' => ''];
        return [
            'url' => $img['url'] ?? ($img['src'] ?? ''),
            'alt' => $img['alt'] ?? '',
            'caption' => $img['caption'] ?? '',
        ];
    })->all();
?>

<div
    x-data="{
        slides: <?php echo \Illuminate\Support\Js::from($normalized)->toHtml() ?>,
        idx: 0,
        playing: <?php echo \Illuminate\Support\Js::from($autoPlay ? true : false)->toHtml() ?>,
        start() {
            if (this.playing && this.slides.length > 1) {
                this._timer = setInterval(() => this.next(), <?php echo \Illuminate\Support\Js::from($interval)->toHtml() ?>);
            }
        },
        stop() { clearInterval(this._timer); this._timer = null; },
        go(i){ this.idx = (i + this.slides.length) % this.slides.length; },
        next(){ this.idx = (this.idx + 1) % this.slides.length; },
        prev(){ this.idx = (this.idx - 1 + this.slides.length) % this.slides.length; }
    }"
    x-init="if (playing && slides.length > 1) start(); $watch('playing', value => value && slides.length > 1 ? start() : stop())"
    class="relative w-full <?php echo e($size); ?> rounded bg-white border-2 border-black/25 <?php echo e($attributes->get('class')); ?>"
>
    <!-- Slideshow container -->
    <div class="relative w-full overflow-hidden rounded"
        style="padding-top: calc(100% / (<?php echo e(explode('/', $aspectRatio)[0]); ?> / <?php echo e(explode('/', $aspectRatio)[1]); ?>));">

        <template x-for="(slide, i) in slides" :key="i">
            <div
                x-show="i === idx"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="absolute inset-0 flex items-center justify-center group"
            >
                <img :src="slide.url" :alt="slide.alt" class="object-cover w-full h-full" />

                <!-- Caption -->
                <div
                    x-show="slide.caption"
                    class="absolute bottom-4 left-4 right-4 bg-black/50 backdrop-blur-xs text-white text-sm p-2 rounded
                        opacity-0 transition-opacity duration-500 group-hover:opacity-100">
                    <span x-text="slide.caption"></span>
                </div>
            </div>
        </template>

        <!-- Prev / Next (only show if more than 1 slide) -->
        <button
            x-show="slides.length > 1"
            @click="prev()"
            class="cursor-pointer absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button
            x-show="slides.length > 1"
            @click="next()"
            class="cursor-pointer absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    <!-- Indicators (only show if more than 1 slide) -->
    <div class="mt-3 flex items-center justify-center gap-2" x-show="slides.length > 1">
        <template x-for="(slide, i) in slides" :key="i">
            <button
                @click="go(i)"
                :class="{'w-8 bg-accent-orange-300': i === idx, 'w-4 bg-gray-300': i !== idx}"
                class="h-2 rounded-full transition-all duration-150"
                :aria-current="i === idx"
                :aria-label="`Go to slide ${i+1}`"
            ></button>
        </template>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/slideshow.blade.php ENDPATH**/ ?>