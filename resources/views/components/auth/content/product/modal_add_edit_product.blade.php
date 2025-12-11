<x-layouts.modal modalID="modal_product" modalMaxWidth="4xl">
    <form @php
        $fileUploadId = 'file_upload_product';
    @endphp id="form_product" x-data="productForm()"
        @submit.prevent="handleSubmit" @modal_closed_fallback.window="handleModalClose($event)"
        @passed_product_data.window="loadProductData($event);"
        @files_empty.window="handleFileUploadModalState($event, true)"
        @files_not_empty.window="handleFileUploadModalState($event, false)"
        x-bind:action="isUpdate() ? routes.update : routes.add" method="POST" enctype="multipart/form-data">
        @csrf

        <section class="grid grid-cols-1 md:grid-cols-[1fr_0.5fr] gap-4">

            {{-- LEFT SIDE --}}
            <section>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">
                            Product Title
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <input x-model="productData.title" @input="checkChanges()"
                            class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                            name="product_name" required />
                    </div>
                    <div class="flex flex-col gap-4">
                        <p class="text-sm font-medium">Visible to public</p>
                        <input name="visibility" type="checkbox" @change="checkChanges();" {{--
                            x-model="productData.is_visible" --}} :checked="Boolean(productData.is_visible)"
                            class="cursor-pointer w-5 h-5 text-accent-orange-300 accent-orange-400 rounded-sm" />
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">Description</p>
                        <textarea x-model="productData.description" @input="checkChanges()" name="description"
                            class="w-full min-h-34 max-h-40 px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"></textarea>
                    </div>
                </div>
            </section>

            {{-- RIGHT SIDE IMAGE SECTION --}}
            <section x-data="{
                showUploadFile: true,
            }" class="flex flex-col gap-2">
                <p class="text-sm font-medium">
                    Images
                    <span class="text-red-500 font-bold">*</span>
                </p>



                <template x-if="productData.images">
                    <div x-data="{
                        init() {
                            showUploadFile = true;
                            if(Object.keys(productData.images).length > 6) {
                                showUploadFile = false;
                            }
                        }
                    }">
                        <input type="hidden" name="product_id" x-bind:value="productData.id" />
                        <input type="hidden" name="product_images" x-bind:value="JSON.stringify(productData.images)" />

                        <div class="grid grid-cols-3 grid-rows-2 gap-2">
                            <template x-for="i in 6" :key="i">
                                <section class="aspect-video rounded relative bg-gray-200 shadow-sm overflow-hidden">

                                    <div x-show="productData.images[i - 1]" class="absolute top-0 right-0 p-1">
                                        <button type="button" @click="removeImage(productData.images[i-1])"
                                            class="cursor-pointer p-1 hover:bg-gray-700/40 rounded-full">
                                            @svg('zondicon-close', 'w-3 h-3 text-white')
                                        </button>
                                    </div>

                                    <img class="object-contain m-auto"
                                        x-bind:src="productData.images[i-1] || '{{ asset('images/reftec_logo_transparent_16x9.png') }}'">
                                </section>
                            </template>
                        </div>
                    </div>
                </template>
                <div class="w-full flex flex-col gap-1" x-show="showUploadFile">
                    <x-layouts.file_upload_drag acceptFile="image/*" file_upload_id="{{ $fileUploadId }}"
                        maxUploadCount="6" multiple />
                </div>
            </section>

        </section>

        {{-- FOOTER BUTTONS --}}
        <section class="flex items-center justify-end gap-2 mt-4">
            <button type="button" :disabled="formDisabled" @click="closeModal()"
                class="px-5 py-2 rounded bg-gray-300 hover:bg-gray-400">
                Cancel
            </button>

            <button type="submit" :disabled="loading"
                class="px-5 py-2 flex items-center justify-center gap-2 rounded bg-accent-orange-300 hover:bg-accent-orange-400 disabled:opacity-50 disabled:cursor-not-allowed">

                <template x-if="loading">
                    @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                </template>

                <span x-text="loading ? 'Saving...' : 'Save'"></span>
            </button>
        </section>

    </form>

    <script>
        function productForm() {
            return {
                loading: false,
                formDisabled: true,
                modal_id: "modal_product",
                file_upload_id: @js($fileUploadId),

                productData: {},
                fakeproductData: {},

                routes: {
                    add: "{{ route('content.add.section.product') }}",
                    update: "{{ route('content.update.section.product') }}",
                },


                /* ---------------------------
                Utility Functions
                ----------------------------*/

                isUpdate() {
                    return this.productData && this.productData.id;
                },

                deepClone(obj) {
                    return JSON.parse(JSON.stringify(obj));
                },

                objectsMatch(a, b) {
                    return JSON.stringify(a) === JSON.stringify(b);
                },

                checkChanges() {
                    this.formDisabled = this.objectsMatch(this.productData, this.fakeproductData);
                },

                removeImage(path) {
                    this.productData.images = this.productData.images.filter(img => img !== path);
                    this.checkChanges();
                },


                /* ---------------------------
                FileUpload Event Handling
                ----------------------------*/
                handleFileUploadModalState(e, state) {
                    if (e.detail.file_upload_id != this.file_upload_id) return;
                    this.formDisabled = state;
                    if (state) this.checkChanges();
                },


                /* ---------------------------
                Modal Event Handling
                ----------------------------*/

                handleModalClose(e) {
                    if (e.detail.modalID !== this.modal_id) return;
                    this.productData = {};
                    this.fakeproductData = {};
                    this.formDisabled = true;
                },

                loadProductData(e) {
                    if (!e.detail.data) return;
                    if (e.detail.modalID !== this.modal_id) return;

                    this.productData = this.deepClone(e.detail.data.product_data);
                    this.fakeproductData = this.deepClone(e.detail.data.product_data);

                    this.checkChanges();
                },

                /* ---------------------------
                Submit
                ----------------------------*/

                handleSubmit() {
                    // if (this.formDisabled) {
                    //     toast("No changes to save.", "warning");
                    //     return;
                    // }
                    this.formDisabled = true;
                    this.loading = true;
                    // $dispatch('force_disable_modal_closing', { modalID: 'modal_product' });
                    window.dispatchEvent(new CustomEvent("force_disable_modal_closing", {
                        detail: { modalID: 'modal_product' }
                    }));
                    this.$el.submit();
                },
            };
        }
    </script>

</x-layouts.modal>