<!DOCTYPE html>
<html lang="en">
<x-partials.head />

<body>
    <x-public.navbar />

    <x-public.content_container minHeight="min-h-[50vh]">
        <div class="flex flex-col items-center justify-center my-12">
            <p class="text-2xl md:text-3xl font-inter font-black">
                <span class="text-accent-black_2">OUR </span>
                <span class="text-accent-orange-300">PRODUCTS</span>
            </p>
            <p class="text-gray-800 text-sm font-medium text-center">THINKING OF INNOVATION? WE GOT YOU COVERED!</p>
        </div>

        <section x-data="productsHandler()">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-2">
                <template x-if="products !== null">
                    <template x-for="(product, index) in products" :key="index">
                        <div :class="Object.keys(products).length === 3 && index === Object.keys(products).length -1 ? 'col-start-1 col-end-3 justify-self-center w-1/2' : ''"
                            class="cursor-pointer bg-white flex flex-col" x-data 
                            @click="$dispatch('image_preview_event', { previewInfo: { image: product.images[0]}})">
                            <img x-bind:src="product.images[0]" class="w-full grow max-h-[200px] object-cover" />
                            <div class="bg-brand-primary-950 p-2 lg:p-4">
                                <p class="text-sm md:text-lg font-inter font-medium text-white" x-text="product.title">
                                </p>
                            </div>
                        </div>
                    </template>
                </template>

            </div>

            <script>
                function productsHandler() {
                    return {
                        products: null,

                        async init() {
                            const response = await fetch('{{ route('content.get.section.products.public') }}');
                            const data = await response.json();
                            if (data && data.success) {
                                this.products = data.data.data;
                            }
                            console.log(this.products);
                        },
                    }
                }
            </script>
        </section>

    </x-public.content_container>

    <x-public.modal.image_preview escKeyToClose clickOutsideToClose />

    <x-public.footer />
</body>

</html>