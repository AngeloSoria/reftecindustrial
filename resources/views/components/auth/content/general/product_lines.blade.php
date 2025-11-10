<h2 class="font-medium text-lg mb-2">Product Lines</h2>

<button @click="$dispatch('open_modal', {'modalID':'add_product_line'})"
    class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded bg-accent-orange-300 hover:bg-accent-orange-400 transition-colors">
    @svg('fluentui-add-circle-24-o', 'w-5 h-5')
    Add Product Line
</button>

<section class="mt-2 gap-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3" x-data="{
        product_lines: [],
        loading: true,
        async init() {
            const response = await fetch('{{ route('content.get.section.product_lines') }}');
            const data = await response.json();
            if (data && data.success) {
                this.product_lines = data.data;
            }
            this.loading = false
        },
    }">

    {{-- Skeleton loading --}}
    <template x-if="loading">
        <template x-for="i in Array.from({ length: 4 }, (_, index) => index)">
            <div
                class="border-2 border-accent-darkslategray-200/25 bg-white rounded shadow overflow-hidden animate-pulse">
                <div class="p-4 bg-accent-darkslategray-200 min-h-[150px] max-h-[150px]"></div>
                <div class="p-4 flex items-center justify-start gap-2">
                    <p class="text-lg p-2 rounded bg-accent-darkslategray-300 max-w-[90%] grow"></p>
                </div>
            </div>
        </template>
    </template>

    {{-- Load real data once the fetching was completed. --}}
    <template x-for="product in product_lines" :key="product.name">
        <div class="border-2 border-accent-darkslategray-200/25 bg-white rounded shadow overflow-hidden">
            <div class="p-4 bg-accent-darkslategray-200 relative">
                <img :src="'storage/' + product.image_path"
                    class="min-h-[150px] max-h-[150px] w-full h-full object-contain" :alt="product.name" />
                <span x-text="product.visibility == 1 ? 'visible' : 'hidden'"
                    :class="product.visibility == 1 ? 'bg-accent-lightseagreen-50 text-white' : 'bg-brand-secondary-300 text-white'"
                    class="scale-[90%] py-1 px-3 capitalize text-xs rounded-full absolute top-2 left-2"></span>
            </div>

            <div class="p-2 flex items-center justify-between gap-3 rounded-md bg-white">
                <!-- Text container -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm break-words truncate whitespace-normal">
                        <span x-text="product.name"></span>
                    </p>
                </div>

                <!-- Action buttons -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <button title="Edit" @click="$dispatch(
                            'modal-open',
                            {
                                view: 'livewire.partials.modal.edit-product-lines',
                                data: { product: product },
                                modalConfig: {
                                    {{-- size: '3xl', --}}
                                    modalHeaderText: 'Edit Product Line',
                                }
                            }
                        )"
                        class="p-2 rounded-full shadow-sm cursor-pointer transition-colors outline-accent-darkslategray-200 hover:bg-blue-600 hover:text-white">
                        @svg('fluentui-edit-20-o', 'w-4 h-4')
                    </button>

                    <button title="Delete" @click="deleteProduct(product)"
                        class="p-2 rounded-full shadow-sm cursor-pointer transition-colors outline-accent-darkslategray-200 hover:bg-red-500 hover:text-white">
                        @svg('fluentui-delete-20-o', 'w-4 h-4')
                    </button>
                </div>
            </div>

        </div>
    </template>

</section>

<livewire:modal />

{{-- Modal: ADD --}}
<x-layouts.modal titleHeaderText="Add new Product Line" modalID="add_product_line" promptAlertBeforeClosing>
    <form method="POST" action="{{ route('content.add.section.product_line') }}" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col flex-wrap items-start justify-center gap-4">

            <div class="w-full flex flex-col gap-1">
                <label for="input_productLineName" class="text-sm font-medium">Name</label>
                <input
                    class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                    id="input_productLineName" name="product_line_name" type="text"
                    placeholder="Enter product line name..." required aria-required="true" />
            </div>

            <div class="w-full ">
                <div class="flex items-center justify-start gap-2">
                    <input id="input_visibility" type="checkbox" name="visibility"
                        class="w-5 h-5 text-accent-orange-300 accent-orange-400 rounded-sm border-2 border-accent-darkslategray-700" />
                    <label for="input_visibility" class="text-sm">Visible</label>
                </div>
            </div>

            <div class="w-full flex flex-col gap-1">
                <label class="text-sm font-medium">Image</label>
                <x-layouts.file_upload_drag required />
            </div>

        </div>

        <section class="flex items-center justify-end gap-2 mt-4">
            <button type="button" @click="closeModal()"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-darkslategray-300 bg-accent-darkslategray-200">
                Cancel
            </button>
            <button type="submit"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-orange-400 bg-accent-orange-300">
                Submit
            </button>
        </section>
    </form>
</x-layouts.modal>

{{-- Modal: Edit --}}
<x-layouts.modal titleHeaderText="Edit Product Line" modalID="edit_product_line" modalMaxWidth="2xl">
    <form method="POST" action="{{ route('content.edit.section.product_line') }}" enctype="multipart/form-data" x-data="{
            productData : null
        }" @passed_product_data.window="
            productData = $event.detail.data;

            console.log('Invoking event: update_switch_state');
            $dispatch('update_switch_state', {
                id: 'input_visibility_2',
                state: productData.product.visibility,
            });

        ">
        @csrf
        <div class="flex flex-col flex-wrap items-start justify-center gap-4">

            <div class="w-full">
                <label class="text-sm font-medium">Image</label>
                <template x-if="productData">
                    <div class="w-full flex items-center justify-center p-4 hover:bg-gray-300 transition-colors">
                        <img :src="'storage/' + productData.product.image_path" alt="Product Image"
                            class="w-64 aspect-auto rounded-sm" />
                    </div>
                </template>
            </div>

            <template x-if="productData">
                <div class="w-full flex flex-col gap-1">
                    <label for="input_productLineName" class="text-sm font-medium">Name</label>
                    <input type="hidden" name="product_id" x-model="productData.product.id" />
                    <input type="text" id="input_productLineName" name="product_line_name"
                        placeholder="Enter product line name..." required aria-required="true"
                        class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                        x-model="productData.product.name" />
                </div>
            </template>

            <template x-if="productData">
                <div class="w-full flex items-center justify-start gap-2">
                    <x-public.switch_toggle id="input_visibility_2" name="visibility"
                        @:customStateValue="productData.product.visibility" label="Visibility" />
                </div>
            </template>

            <div class="w-full flex flex-col gap-1">
                <label class="text-sm font-medium">Upload image</label>
                <x-layouts.file_upload_drag required />
            </div>



        </div>

        <section class="flex items-center justify-end gap-2 mt-4">
            <button type="button" @click="closeModal()"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-darkslategray-300 bg-accent-darkslategray-200">
                Cancel
            </button>
            <button type="submit"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-orange-400 bg-accent-orange-300">
                @svg('fluentui-checkmark-16', 'w-5 h-5')
                Save Changes
            </button>
        </section>
    </form>
</x-layouts.modal>

{{-- Modal: Delete --}}
