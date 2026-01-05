<x-layouts.auth.app viewName="Test" class="font-inter p-4" x-data>

    <div class="relative w-full overflow-hidden bg-white rounded-lg shadow fade-edges-horizontal">

        <div class="flex w-max animate-logo-conveyor items-center">

            <!-- First set -->
            <div class="flex shrink-0 items-center justify-center">
                {{-- <img src="{{ asset('images/kingspan.jpg') }}"
                    class="h-12 sm:h-14 md:h-16 mx-10 transition-all duration-300" />
                <img src="{{ asset('images/starr.jpg') }}"
                    class="h-12 sm:h-14 md:h-16 mx-10 transition-all duration-300" />
                <img src="{{ asset('images/vilter_logo.png') }}"
                    class="h-12 sm:h-14 md:h-16 mx-10 transition-all duration-300" /> --}}
                <img src="{{ asset('images/reftec_logo_transparent.png') }}"
                    class="h-12 sm:h-14 md:h-16 mx-10 transition-all duration-300" />
            </div>

            <!-- Duplicate set (required for seamless loop) -->
            <div class="flex shrink-0 items-center justify-center">
                <img src="{{ asset('images/kingspan.jpg') }}"
                    class="h-12 sm:h-14 md:h-16 mx-10 transition-all duration-300" />
                {{-- <img src="{{ asset('images/starr.jpg') }}"
                    class="h-12 sm:h-14 md:h-16 mx-10 transition-all duration-300" />
                <img src="{{ asset('images/vilter_logo.png') }}"
                    class="h-12 sm:h-14 md:h-16 mx-10 transition-all duration-300" />
                <img src="{{ asset('images/reftec_logo_transparent.png') }}"
                    class="h-12 sm:h-14 md:h-16 mx-10 transition-all duration-300" /> --}}
            </div>

        </div>
    </div>

    <x-public.content_container>
        <section x-data="{
            productLines: [
                {
                    'image': '{{ asset('images/product_lines/kingspan.jpg') }}',
                    'title': 'Kingspan'
                },   
                {
                    'image': '{{ asset('images/product_lines/Vilter_logo_transparent.png') }}',
                    'title': 'Vilter'
                },  
                {
                    'image': '{{ asset('images/product_lines/starr.jpg') }}',
                    'title': 'Starr Panel'
                },
            ],
        }">
            <section class="fade-edges-horizontal overflow-hidden">
                <div 
                class="flex items-center"
                :class="Object.keys(productLines).length > 2 ? 'animate-logo-conveyor' : 'justify-center'"
                >
                <template x-for="i in Array.from({ length: Object.keys(productLines).length > 2 ? 2 : 1 }, (_, index) => index)">
                    <template x-for="productLine in productLines">
                        <div class="grow p-4 flex flex-col items-center justify-center">
                            <img
                            :src="productLine.image" 
                            :title="productLine.title" 
                            class="max-w-30 sm:max-w-40 md:max-w-80 max-h-24 object-contain bg-white transition-all duration-300"
                            />
                        </div>
                    </template>
                </template>
                </div>
            </section>
        </section>
    </x-public.content_container>

</x-layouts.auth.app>


<div class="mt-4 bg-accent-darkslategray-900 grid gap-1 md:gap-0 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 relative"
                data-aos="fade-up" data-aos-anchor-placement="center-center" x-data="{
                    productLines: [],
                    async init() {
                        try {
                            const response = await fetch('{{ route('content.get.section.product_lines.visible') }}');
                            const data = await response.json();
                            this.productLines = data.data;
                            console.log(this.productLines);
                        } catch (e) {
                            console.error('Failed to load product lines:', e);
                        }
                    },
                }">
                <template x-for="line in productLines" :key="line.name">
                    <section class="w-full relative h-24 overflow-hidden">
                        {{-- Image --}}
                        <img :src="line.image_path" :alt="line.name" class="w-full m-auto" />

                        {{-- Product Name --}}
                        <div class="z-2 w-[90%] absolute bottom-0 left-1/2 -translate-x-1/2 p-2 text-white text-center">
                            <h2 class="text-sm text-shadow font-medium" x-text="line.name"></h2>
                        </div>

                        {{-- Bottom Vignette --}}
                        <div
                            class="z-1 absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-black/90 to-transparent pointer-events-none">
                        </div>
                    </section>
                </template>
            </div>