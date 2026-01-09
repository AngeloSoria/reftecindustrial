<x-layouts.modal modalID="modal_delete_product" modalMaxWidth="md">
    <section x-data="deleteProductForm()" @modal_closed_fallback.window="handleModalClose($event)">
        <section>
            <h2>Product Info:</h2>

            <section class="p-2 bg-gray-200 rounded">
                <div class="flex gap-2">
                    <p class="font-bold">Product Id:</p>
                    <span x-text="productData.id"></span>
                </div>
                <div class="flex gap-2">
                    <p class="font-bold">Title:</p>
                    <span x-text="productData.title"></span>
                </div>
            </section>

        </section>
        <section>
            <form method="POST" @payload_event.window="loadProductData($event);" @submit.prevent="formSubmit()"
                x-data action="{{ route('content.delete.section.product') }}">
                @csrf
                <input type="hidden" name="product_id" x-bind:value="productData.id" />
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
            function deleteProductForm() {
                return {
                    productData: {},
                    loading: false,
                    formDisabled: false,

                    formSubmit() {
                        this.loading = true;
                        this.formDisabled = true;

                        window.dispatchEvent(new CustomEvent("force_disable_modal_closing", {
                            detail: { modalID: 'modal_delete_product' }
                        }));

                        this.$el.submit();
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
                    },
                }
            }
        </script>
    </section>
</x-layouts.modal>