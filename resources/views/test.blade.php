<x-layouts.auth.app viewName="Test" class="font-inter p-4" x-data>

    <button
    
    x-data="test"
    @click="clickMe"
    >
        Click me!
    </button>
    <script>
        function test() {
            return {
                async clickMe() {
                    console.time('web');
                    const response1 = await fetch(
                        "{{ route('api.content.page.home') }}"
                    );
                    await response1.json();
                    console.timeEnd('web');
                }
            }
        }
    </script>

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
                <div class="flex items-center"
                    :class="Object.keys(productLines).length > 2 ? 'animate-logo-conveyor' : 'justify-center'">
                    <template
                        x-for="i in Array.from({ length: Object.keys(productLines).length > 2 ? 2 : 1 }, (_, index) => index)">
                        <template x-for="productLine in productLines">
                            <div class="grow p-4 flex flex-col items-center justify-center">
                                <img :src="productLine.image" :title="productLine.title"
                                    class="max-w-30 sm:max-w-40 md:max-w-80 max-h-24 object-contain bg-white transition-all duration-300" />
                            </div>
                        </template>
                    </template>
                </div>
            </section>
        </section>
    </x-public.content_container>

</x-layouts.auth.app>
