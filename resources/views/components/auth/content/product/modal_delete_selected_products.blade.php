<x-layouts.modal modalID="modal_delete_products" modalMaxWidth="2xl">
    <section x-data="deleteProductsForm()" @modal_closed_fallback.window="handleModalClose($event)">
        <section>
            <h2>
                <span x-text="Object.keys(productData).length"></span>
                Products Info:
            </h2>

            <section class="p-2 bg-gray-200 rounded grid grid-cols-2 gap-2 max-h-[400px] overflow-y-auto">
                <template x-if="productData && Object.keys(productData).length > 0">
                    <template x-for="(product, index) in productData" :key="product + '_' + index">
                        <section class="bg-gray-100 rounded-sm shadow-card p-3 w-full h-full flex flex-col gap-2">
                            <div class="flex gap-2">
                                <p class="font-sans font-medium text-sm">Job Order:</p>
                                <span x-text="product.job_order"></span>
                            </div>
                            <div class="flex gap-2">
                                <p class="font-sans font-medium text-sm">Visibility:</p>
                                <span x-text="product.is_visible > 0 ? 'Visible' : 'Hidden'"></span>
                            </div>
                            <div class="flex gap-2">
                                <p class="font-sans font-medium text-sm">Title:</p>
                                <span x-text="product.title" class="text-sm"></span>
                            </div>
                        </section>
                    </template>
                </template>
            </section>

        </section>
        <section>
            <form method="POST" action="{{ route('content.delete.section.products.selected') }}"
                @passed_product_data.window="loadProductData($event);" @submit.prevent="formSubmit()">
                @csrf
                <input type="hidden" name="products" x-bind:value="JSON.stringify(productData)" />
                <div class="mt-4 flex justify-end items-start gap-2">
                    <x-public.button type="button" button_type="default" x-bind:disabled="formDisabled"
                        @click="closeModal()">
                        Cancel
                    </x-public.button>
                    <x-public.button type="submit" x-bind:disabled="loading"
                        class="cursor-pointer text-white bg-red-500 hover:bg-red-400 active:bg-red-600 transition-colors disabled:opacity-50 flext items-center justify-center gap-2">
                        <template x-if="loading">
                            @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                        </template>
                        <span x-text="loading ? 'Deleting...' : 'Delete'"></span>
                    </x-public.button>
                </div>
            </form>
        </section>
        <script>
            function deleteProductsForm() {
                return {
                    productData: {},
                    loading: false,
                    formDisabled: false,

                    formSubmit() {
                        this.formDisabled = false;
                        this.loading = true;
                        this.$el.submit();
                        // $dispatch('force_disable_modal_closing', { modalID: 'modal_delete_products' });
                        window.dispatchEvent(new CustomEvent("force_disable_modal_closing", {
                            detail: { modalID: 'modal_delete_products' }
                        }));
                    },

                    handleModalClose(e) {
                        if (e.detail.modalID !== this.modal_id) return;
                        this.productData = {};
                        this.formDisabled = true;
                    },

                    loadProductData(e) {
                        if (!e.detail.data) return;
                        if (e.detail.modalID !== this.modal_id) return;
                        this.productData = e.detail.data.product_data;
                        console.log(this.productData);
                    },
                }
            }
        </script>
    </section>
</x-layouts.modal>