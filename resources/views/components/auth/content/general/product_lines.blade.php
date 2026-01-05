<h2 class="font-medium text-lg mb-2">Product Lines</h2>

<x-public.button button_type="primary" @click="$dispatch('openmodal', {
        modalID: 'modal_product_line',
        modal_header_text: 'Add New Product Line'
    })">
    @svg('fluentui-add-circle-24-o', 'w-5 h-5')
    Add Product Line
</x-public.button>

<section x-data="{
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

    {{-- Item wrapper --}}
    <section class="mt-2 gap-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        {{-- Skeleton loading --}}
        <template x-if="loading">
            <template x-for="i in Array.from({ length: 5 }, (_, index) => index)">
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
        <!-- Check if there are product lines -->
        <template x-if="product_lines.length === 0 && !loading">
            <p class="text-center text-gray-500 py-4">No product lines available.</p>
        </template>

        <!-- Loop through products if any -->
        <template x-for="product in product_lines" :key="product.name">
            <div class="border bg-white rounded overflow-hidden hover:shadow-sm transition-shadow">
                <div class="p-3 relative hover:bg-gray-100 transition-colors">
                    <img :src="product.image_path"
                        class="min-h-[150px] max-h-[150px] w-full h-full object-contain" :alt="product.name" />
                    <span x-text="product.visibility == 1 ? 'visible' : 'hidden'"
                        :class="product.visibility == 1 ? 'bg-accent-lightseagreen-50 text-white' : 'bg-brand-secondary-300 text-white'"
                        class="scale-[90%] py-1 px-3 capitalize text-xs rounded-full absolute top-2 left-2"></span>
                </div>

                <div class="p-2 flex items-center justify-between gap-3 bg-white">
                    <!-- Text container -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm break-words truncate whitespace-normal">
                            <span x-text="product.name"></span>
                        </p>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <button title="Edit" @click="$dispatch(
                            'openmodal',
                            {
                                modalID: 'modal_product_line',
                                modal_header_text: 'Edit Product Line',
                                special_data: {
                                    product_data: product,
                                },
                            }
                        )"
                            class="p-2 rounded-full shadow-sm cursor-pointer transition-colors outline-accent-darkslategray-200 hover:bg-blue-600 hover:text-white">
                            @svg('fluentui-edit-20-o', 'w-4 h-4')
                        </button>

                        <button title="Delete" @click="$dispatch(
                            'openmodal',
                            {
                                modalID: 'modal_delete_product_line',
                                modal_header_text: 'Delete Product Line',
                                special_data: {
                                    product_data: product,
                                }
                            }
                        )"
                            class="p-2 rounded-full shadow-sm cursor-pointer transition-colors outline-accent-darkslategray-200 hover:bg-red-500 hover:text-white">
                            @svg('fluentui-delete-20-o', 'w-4 h-4')
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </section>

</section>

{{-- Modal: ADD / UPDATE / EDIT --}}
<x-layouts.modal modalID="modal_product_line">

    <form @php
        $fileUploadId = 'file_upload_hero';
    @endphp x-data="{
            routes: {
                add: '{{ route('content.add.section.product_line') }}',
                update: '{{ route('content.edit.section.product_line') }}',
            },
            modal_id: 'modal_product_line',
            productData : {},

            file_upload_id: @js($fileUploadId),
            loading: false,
            formDisabled: true,
            async init() {
                this.$watch('productData.name', value => {
                    this.updateFormState();
                });
            },
            updateFormState() {
                // If editing existing product, always allow submission
                if (Object.keys(this.productData).length > 0) {
                    this.formDisabled = false;
                    return;
                }

                // Text input field
                const nameFilled = this.productData.name?.trim() !== '';

                // File upload emits its own empty/not_empty events you already catch:
                // files_empty.window → formDisabled = true
                // files_not_empty.window → formDisabled = false
                // So here we only check the text fields

                this.formDisabled = !nameFilled;
            },

        }" 
        @passed_product_data.window="
            if (!$event.detail.data) { console.error('No data passed.') }
            if (!event.detail.modalID) { console.error('No modal ID passed. \n modal_id: ' + modal_id); }
            if ($event.detail.modalID !== modal_id) { return }
            productData = $event.detail.data.product_data;
            if(productData.visibility) {
                productData.visibility = productData.visibility == 1 ? true : false;
            }
            productData.image_required = productData.image_path ? false : true;
        " @submit.prevent="
            loading = true;
            if(formDisabled) {
                toast('all required fields in the form must have value first.', 'warning');
                return;
            }
            $dispatch('form_in_submit_phase', { file_upload_id: file_upload_id });
            $el.submit();
        " @modal_closed_fallback.window="
            if($event.detail.modalID !== modal_id ) { return }
            productData = {};
            $dispatch('reset_file_upload', { file_upload_id: file_upload_id });
        " @files_empty.window="
            if($event.detail.file_upload_id != file_upload_id) return;
            formDisabled = true;
        " @files_not_empty.window="
            if($event.detail.file_upload_id != file_upload_id) return;
            formDisabled = false;
        " method="POST" :action="productData && productData.id ? routes.update : routes.add"
        enctype="multipart/form-data">

        @csrf

        <div class="flex flex-col flex-wrap items-start justify-center gap-4">

            <template x-if="productData && productData.id">
                <input type="hidden" name="product_line_id" :value="productData.id" />
            </template>

            {{-- Image --}}
            <template x-if="productData && productData.image_path">
                <div class="w-full flex items-center justify-center p-4 hover:bg-gray-300 transition-colors">
                    <img :src="productData.image_path" alt="Product Image"
                        class="max-w-64 aspect-auto rounded-sm" />
                </div>
            </template>


            <div class="w-full flex flex-col gap-1">
                <label for="input_productLineName" class="text-sm font-medium">
                    Name
                    <span class="text-red-500 font-bold">*</span>
                </label>
                <input x-model="productData.name"
                    class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                    id="input_productLineName" name="product_line_name" type="text"
                    placeholder="Enter product line name..." required aria-required="true" />
            </div>

            <div class="w-full ">
                <div class="flex items-center justify-start gap-2">
                    <input id="input_visibility" type="checkbox" name="visibility" x-model="productData.visibility"
                        :checked="productData.visibility" :value="productData.visibility ? 1 : 0"
                        class="w-5 h-5 text-accent-orange-300 accent-orange-400 rounded-sm border-2 border-accent-darkslategray-700" />
                    <label for="input_visibility" class="text-sm">Visible</label>
                </div>
            </div>

            <div class="w-full flex flex-col gap-1">
                <label class="text-sm font-medium">
                    <template x-if="Object.keys(productData).length > 0 && productData.image_path">
                        <span>Upload an Image to Update</span>
                    </template>

                    <template x-if="!productData.image_path">
                        <span>
                            Image
                            <span class="text-red-500 font-bold">*</span>
                        </span>
                    </template>

                </label>
                <x-layouts.file_upload_drag acceptFile="image/*" file_upload_id="file_upload_product_line" />
            </div>

        </div>

        <section class="flex items-center justify-end gap-2 mt-4">
            <button type="button" @click="closeModal()"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-darkslategray-300 bg-accent-darkslategray-200">
                Cancel
            </button>
            <button type="submit" :disabled="loading || formDisabled"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-orange-400 bg-accent-orange-300 disabled:opacity-50 disabled:cursor-not-allowed">
                <template x-if="loading">
                    @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                </template>
                <span x-text="loading ? 'Saving...' : 'Save'"></span>
            </button>
        </section>
    </form>
</x-layouts.modal>


{{-- Modal: Delete --}}
<x-layouts.modal modalID="modal_delete_product_line" modalMaxWidth="md">
    <form x-data="{
            modal_id: 'modal_delete_product_line',
            productData : null,
            routes: {
                delete: '{{ route('content.delete.section.product_line') }}',
            },
            loading: false,
        }" @passed_product_data.window="
            if (!$event.detail.data) { console.error('No data passed.') }
            if (!event.detail.modalID) { console.error('No modal ID passed. \n modal_id: ' + modal_id); }
            if ($event.detail.modalID !== modal_id) { return }
            productData = $event.detail.data.product_data;
        " @modal_closed_fallback.window="
            if($event.detail.modalID !== modal_id ) { return }
            productData = null;
        " @submit.prevent="
            loading = true;
            $dispatch('force_disable_modal_closing', { modalID: modal_id });
            $el.submit();
        " method="POST" :action="routes.delete">

        @csrf

        <div class="flex flex-col flex-wrap items-start justify-center gap-4">
            <template x-if="productData">
                <div>
                    <template x-if="productData.id">
                        <input type="hidden" name="product_line_id" :value="productData.id" />
                    </template>

                    <p>
                        Are you sure you want to delete the product line:
                        <strong x-text="productData.name"></strong>?
                    </p>
                </div>
            </template>
        </div>


        <section class="flex items-center justify-end gap-2 mt-4">
            <button type="button" @click="closeModal()" :disabled="loading"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-gray-950 hover:bg-accent-darkslategray-300 bg-accent-darkslategray-200 disabled:opacity-50 disabled:cursor-not-allowed">
                Cancel
            </button>
            <button type="submit" :disabled="loading"
                class="px-5 py-2 rounded cursor-pointer flex items-center justify-center gap-2 text-white hover:bg-red-600 bg-red-500 disabled:opacity-50 disabled:cursor-not-allowed">
                <template x-if="loading">
                    @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                </template>
                <span x-text="loading ? 'Deleting...' : 'Delete'"></span>
            </button>
        </section>
    </form>
</x-layouts.modal>
