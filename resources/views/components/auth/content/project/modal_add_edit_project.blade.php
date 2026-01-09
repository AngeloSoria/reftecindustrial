<x-layouts.modal modalID="modal_project" modalMaxWidth="4xl">
    <form @php
        $fileUploadId = 'file_upload_project';
    @endphp id="form_project" x-data="projectForm()"
        @submit.prevent="handleSubmit" @modal_closed_fallback.window="handleModalClose($event)"
        @payload_event.window="loadProjectData($event);"
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
                            Job Order
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <input x-model="projectData.job_order" @input="checkChanges()"
                            class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                            name="job_order" required />
                    </div>

                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">
                            Project Name
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <input x-model="projectData.title" @input="checkChanges()"
                            class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                            name="project_name" required />
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">Description</p>
                        <textarea x-model="projectData.description" @input="checkChanges()" name="description"
                            class="w-full min-h-34 max-h-40 px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"></textarea>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2 items-start justify-start">
                        <p class="text-sm font-medium">
                            Status
                            <span class="text-red-500 font-bold">*</span>
                        </p>
                        <select x-model="projectData.status" @change="checkChanges()"
                            class="w-full px-4 py-2 rounded border-2 border-gray-200" name="status" required>
                            <option disabled value="">Select status...</option>
                            <option value="pending">Pending</option>
                            <option value="on_going">On Going</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2 items-start">
                        <div class="flex flex-col gap-4">
                            <p class="text-sm font-medium">Visible to public</p>
                            <input name="visibility" type="checkbox" @change="checkChanges();" {{--
                                x-model="projectData.is_visible" --}} :checked="Boolean(projectData.is_visible)"
                                class="cursor-pointer w-5 h-5 border-2 accent-orange-400" />
                        </div>

                        <div class="flex flex-col gap-4">
                            <p class="text-sm font-medium flex">
                                Highlighted
                                <span class="ml-2" title="Will be shown in the homepage. (Max 3 projects)">
                                    @svg('fluentui-question-circle-24', 'w-4 h-4 text-gray-700')
                                </span>
                            </p>
                            <input name="highlighted" 
                                type="checkbox" 
                                class="cursor-pointer w-5 h-5 border-2 accent-orange-400" 
                                @change="checkChanges()" 
                                x-bind:checked="Boolean(projectData.is_featured)"/>
                        </div>
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



                <template x-if="projectData.images">
                    <div x-data="{
                        init() {
                            showUploadFile = true;
                            if(Object.keys(projectData.images).length > 6) {
                                showUploadFile = false;
                            }
                        }
                    }">
                        <input type="hidden" name="project_id" x-bind:value="projectData.id" />
                        <input type="hidden" name="project_images" x-bind:value="JSON.stringify(projectData.images)" />

                        <div class="grid grid-cols-3 grid-rows-2 gap-2">
                            <template x-for="i in 6" :key="i">
                                <section class="aspect-video rounded relative bg-gray-200 shadow-sm overflow-hidden">

                                    <div x-show="projectData.images[i - 1]" class="absolute top-0 right-0 p-1">
                                        <button type="button" @click="removeImage(projectData.images[i-1])"
                                            class="cursor-pointer p-1 hover:bg-gray-700/40 rounded-full">
                                            @svg('zondicon-close', 'w-3 h-3 text-white')
                                        </button>
                                    </div>

                                    <img class="object-contain m-auto"
                                        x-bind:src="projectData.images[i-1] || '{{ asset('images/reftec_logo_transparent_16x9.png') }}'">
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
                class="cursor-pointer px-5 py-2 rounded bg-gray-300 hover:bg-gray-400 transition-colors">
                Cancel
            </button>

            <button type="submit" :disabled="loading"
                class="cursor-pointer px-5 py-2 flex items-center justify-center gap-2 rounded transition-colors bg-accent-orange-300 hover:bg-accent-orange-400 disabled:opacity-50 disabled:cursor-not-allowed">

                <template x-if="loading">
                    @svg('antdesign-loading-3-quarters-o', 'w-5 h-5 animate-spin')
                </template>

                <span x-text="loading ? 'Saving...' : 'Save'"></span>
            </button>
        </section>

    </form>

    <script>
        function projectForm() {
            return {
                loading: false,
                formDisabled: false,
                modal_id: "modal_project",
                file_upload_id: @js($fileUploadId),

                projectData: {},
                fakeProjectData: {},

                routes: {
                    add: "{{ route('content.add.section.project') }}",
                    update: "{{ route('content.update.section.project') }}",
                },


                /* ---------------------------
                Utility Functions
                ----------------------------*/

                isUpdate() {
                    return this.projectData && this.projectData.id;
                },

                deepClone(obj) {
                    return JSON.parse(JSON.stringify(obj));
                },

                objectsMatch(a, b) {
                    return JSON.stringify(a) === JSON.stringify(b);
                },

                checkChanges() {
                    this.formDisabled = this.objectsMatch(this.projectData, this.fakeProjectData);
                },

                removeImage(path) {
                    this.projectData.images = this.projectData.images.filter(img => img !== path);
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
                    this.projectData = {};
                    this.fakeProjectData = {};
                },

                loadProjectData(e) {
                    if (!e.detail.data) return;
                    if (e.detail.modalID !== this.modal_id) return;
                    this.projectData = this.deepClone(e.detail.data.product_data);
                    this.fakeProjectData = this.deepClone(e.detail.data.product_data);
                    
                    this.checkChanges();
                },

                /* ---------------------------
                Submit
                ----------------------------*/

                handleSubmit() {
                    this.formDisabled = true;
                    this.loading = true;
                    window.dispatchEvent(new CustomEvent("force_disable_modal_closing", {
                        detail: { modalID: 'modal_project' }
                    }));
                    this.$el.submit();
                },
            };
        }
    </script>

</x-layouts.modal>