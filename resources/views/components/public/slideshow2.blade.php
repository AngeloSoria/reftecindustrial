@props([
    'slideshow_id' => uniqid('slideshow_id_')
])

<div class="w-full flex justify-center items-center">
    <div x-data="slideshow()" x-init="init()" @slideshow:set.window="setSlides($event.detail)"
        class="relative w-full rounded bg-white">

        <section class="mx-auto">
            <div class="relative overflow-hidden rounded w-full aspect-[16/9] min-w-full">
                <template x-for="(slide, i) in slides" :key="slide.url">
                    <div x-show="i === idx" x-transition.opacity class="absolute inset-0">
                        <img :src="slide.url" :alt="slide.alt" class="object-cover w-full h-full" />
                    </div>
                </template>
                <!-- Controls -->
                <template x-if="slides.length > 1">
                    <div class="absolute top-0 left-0 w-full h-full">
                        <!-- Previous Button -->
                        <button @click="prev()"
                            class="cursor-pointer absolute top-1/2 left-2 transform -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/50 focus:outline-none"
                            aria-label="Previous Slide">
                            &#10094;
                        </button>
                        <!-- Next Button -->
                        <button @click="next()"
                            class="cursor-pointer absolute top-1/2 right-2 transform -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/50 focus:outline-none"
                            aria-label="Next Slide">
                            &#10095;
                        </button>
                        <!-- Indicators -->
                        <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            <template x-for="(slide, i) in slides" :key="i">
                                <button @click="go(i)" :class="{'bg-white': i === idx, 'bg-gray-500': i !== idx}"
                                    class="cursor-pointer w-3 h-3 rounded-full" aria-label="Go to slide"></button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </section>


    </div>


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('slideshow', () => ({
                slideshow_id: @js($slideshow_id),
                slides: [],
                idx: 0,
                interval: 4000,
                playing: false,
                aspectRatio: '16/9',
                _timer: null,

                get aspectPadding() {
                    const [w, h] = this.aspectRatio.split('/');
                    return `calc(100% / (${w} / ${h}))`;
                },

                init() {
                    this.$watch('playing', value => {
                        value ? this.start() : this.stop();
                    });
                },

                normalize(images) {
                    return (images ?? []).map(img => {
                        if (typeof img === 'string') {
                            return { url: img, alt: '', caption: '' };
                        }

                        // map actual property from your backend
                        return {
                            url: img.url ?? img.src ?? img.path ?? img.image ?? '',
                            alt: img.alt ?? '',
                            caption: img.caption ?? '',
                        };
                    });
                },

                setSlides(payload) {
                    if (payload.slideshow_id && payload.slideshow_id !== this.slideshow_id) {
                        return;
                    }

                    this.stop();

                    let images = payload.images;

                    this.slides = this.normalize(images);
                    this.aspectRatio = payload.aspectRatio ?? '16/9';
                    this.interval = payload.interval ?? 4000;
                    this.playing = payload.autoPlay ?? false;
                    this.idx = 0;

                    this.$nextTick(() => {
                        // Force Alpine to recalc the DOM visibility
                        this.idx = 0;
                    });

                    if (this.playing && this.slides.length > 1) {
                        this.start();
                    }
                },

                start() {
                    if (this._timer || this.slides.length < 2) return;
                    this._timer = setInterval(() => this.next(), this.interval);
                },

                stop() {
                    clearInterval(this._timer);
                    this._timer = null;
                },

                next() {
                    this.idx = (this.idx + 1) % this.slides.length;
                },

                prev() {
                    this.idx = (this.idx - 1 + this.slides.length) % this.slides.length;
                },

                go(i) {
                    this.idx = i;
                },
            }));
        });
    </script>


</div>