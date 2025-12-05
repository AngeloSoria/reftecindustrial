<div>
    <section x-data="{
        checkboxActive: false,
        dataLoading: true,
        projectData: null,
        async init() {
            const response = await fetch('{{ route('content.get.section.projects') }}');
            const data = await response.json();
            console.log(data);
            if(data && data.success) {
                this.projectData = data.data;
                this.dataLoading = false;
            }
        },
        async changeSourceData(route) {
            if(!route) {
                console.warn('No route passed when calling changeSourceData');
                return;
            }
            const response = await fetch(route);
            const data = await response.json();
            console.log(data);
            if(data && data.success) {
                this.projectData = data.data;
                this.dataLoading = false;
            }
        },
    }">
        <div class="p-2 flex items-end justify-end gap-2 flex-wrap mt-4">
            <x-public.button @click="$dispatch('openmodal', {
                modalID: 'modal_project',
                modal_header_text: 'Add Project'
            })" button_type="primary">
                <span class="flex items-center justify-center gap-2">
                    @svg('fluentui-add-circle-24-o', 'w-5 h-5')
                    Add New Project
                </span>
            </x-public.button>

            <div x-transition x-show="checkboxActive" class="flex items-start justify-center">
                <x-public.button size="sm" x-data @click="console.log(123)"
                    class="bg-red-500 hover:bg-red-400 transition-colors cursor-pointer">
                    <span class="flex items-center justify-center gap-2">
                        @svg('fluentui-delete-28-o', 'w-5 h-5')
                        Delete Selected
                    </span>
                </x-public.button>
            </div>

            <div class="cursor-pointer relative p-2 rounded bg-white shadow-sm border border-transparent hover:border-accent-darkslategray-200/50 transition-colors"
                x-data="{
                    isOpened: false,
                    toggle(e) {
                        const isParent = e.target === e.currentTarget;
                        const isSvg = e.target.closest('.menu-trigger') !== null;

                        if (isParent || isSvg) {
                            this.isOpened = !this.isOpened;
                        }
                    },
                }" @click="toggle($event)" @click.outside="if(isOpened) isOpened = false">
                <span class="menu-trigger">
                    @svg('fluentui-more-vertical-24-o', 'w-6 h-6')
                </span>

                <div x-transition x-show="isOpened"
                    class="min-w-sm max-w-md absolute bottom-0 right-0 translate-y-[100%] bg-white p-2 rounded shadow-sm">
                    <ul class="space-y-1 *:hover:bg-gray-200 *:p-2 *:text-sm *:rounded-sm *:cursor-pointer">
                        <li @click="console.log('in test mode')" title="Export data as csv file"
                            class="flex justify-start items-center gap-2">
                            @svg('fluentui-drawer-arrow-download-20-o', 'w-4 h-4')
                            <span class="grow">Export Data as CSV</span>
                        </li>
                        <li @click="console.log('in test mode')" title="Import data"
                            class="flex justify-start items-center gap-2">
                            @svg('zondicon-upload', 'w-4 h-4')
                            <span class="grow">Import Data</span>
                        </li>
                        <li @click="console.log('in test mode')" title="Download data"
                            class="flex justify-start items-center gap-2">
                            @svg('zondicon-download', 'w-4 h-4')
                            <span class="grow">Download Sample Template</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="p-6 overflow-auto px-0 outline rounded outline-accent-darkslategray-400/15">
            <table class="w-full min-w-max table-auto text-left rounded-t-md">
                <thead>
                    <tr
                        class="bg-brand-primary-200/75 shadow-sm [&>*:first-child]:rounded-tl-sm [&>*:last-child]:rounded-tr-sm [&>*]:border-y [&>*]:border-gray-200 [&>*]:cursor-pointer [&>*]:p-2 [&>*]:transition-colors [&>*]:hover:bg-gray-200">
                        <th class="rounded-tl-md">
                            <input type="checkbox" id="input_checkbox_selectAll" x-data="{
                                    titleContent: 'Select All'
                                }" @click="
                                    titleContent = $el.checked ? 'Deselect All' : 'Select All';
                                    checkboxActive = $el.checked;
                                " x-bind:title="titleContent"
                                class="m-auto cursor-pointer w-5 h-5 text-accent-orange-300 accent-orange-400 rounded-sm border-2 border-accent-darkslategray-700" />
                        </th>

                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 flex items-center justify-between gap-2 font-normal leading-none">
                                Images
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 flex items-center justify-between gap-2 font-normal leading-none">
                                Job Order
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 flex items-center justify-between gap-2 font-normal leading-none">
                                Title
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 flex items-center justify-between gap-2 font-normal leading-none">
                                Description
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 flex items-center justify-between gap-2 font-normal leading-none">
                                Status
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 flex items-center justify-between gap-2 font-normal leading-none">
                                Visible
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 flex items-center justify-between gap-2 font-normal leading-none">
                                Highlight (#/3)
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 flex items-center justify-between gap-2 font-normal leading-none">
                                Actions
                            </p>
                        </th>
                    </tr>
                </thead>
                <tbody x-data>
                    <template x-if="dataLoading">
                        <tr>
                            <td colspan="9" rowspan="3">
                                <span class="p-4 flex items-center justify-center">
                                    <p class="italic opacity-50 font-medium text-xl">Loading projects...</p>
                                </span>
                            </td>
                        </tr>
                    </template>

                    <template x-if="!dataLoading && projectData">
                        <template x-for="(project, index) in projectData.data" :key="project.job_order + '_' + index">
                            <tr
                                class="odd:bg-accent-darkslategray-100 even:bg-accent-darkslategray-50 *:p-2 *:border-b *:border-gray-50">
                                <td>
                                    <input type="checkbox"
                                        class="input_checkbox_item cursor-pointer w-5 h-5 text-accent-orange-300 accent-orange-400 rounded-sm border-2 border-accent-darkslategray-700" />
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div x-data="{
                                            get imageCount() {
                                                return project.images?.length ?? 0;
                                            },
                                            get gridClass() {
                                                const count = this.imageCount;

                                                // 1 item → 1x1
                                                if (count === 1) return 'grid-cols-1 grid-rows-1';

                                                // 2 items → 2x1
                                                if (count === 2) return 'grid-cols-2 grid-rows-1';

                                                // 3 or 4 items → 2x2
                                                if (count === 3 || count === 4) return 'grid-cols-2 grid-rows-2';

                                                // 5 or 6 items → 2x3 (max)
                                                return 'grid-cols-2 grid-rows-3';
                                            }
                                        }" :class="gridClass" class="grid gap-1 max-w-[125px]">
                                            <template x-for="(image_path, index) in project.images"
                                                :key="image_path + '_' + index">
                                                <img @click="$dispatch('image_preview_event', { previewInfo: { image: $el.src }});"
                                                    x-bind:src="image_path"
                                                    class="aspect-video rounded cursor-pointer brightness-75 hover:brightness-100 transition-all" />
                                            </template>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <p class="block antialiased font-sans text-sm leading-normal text-gray-900 font-normal text-center"
                                            x-text="project.job_order"></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="w-max overflow-x-auto max-w-[125px] whitespace-normal break-words">
                                        <p class="block antialiased font-sans text-sm leading-normal text-gray-900 font-normal"
                                            x-text="project.title"></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="w-max overflow-x-auto max-w-[200px] whitespace-normal break-words">
                                        <p class="block antialiased font-sans text-sm leading-normal text-gray-900 font-normal"
                                            x-text="project.description"></p>
                                    </div>
                                </td>
                                <td>
                                    <template x-if="project.status == 'pending'">
                                        <div class="scale-[80%] relative grid items-center font-sans font-bold uppercase whitespace-nowrap select-none bg-orange-400/20 text-orange-600 py-1 px-2 text-xs rounded-md"
                                            style="opacity: 1;">
                                            <span class="text-center">Pending</span>
                                        </div>
                                    </template>
                                    <template x-if="project.status == 'on_going'">
                                        <div class="scale-[80%] relative grid items-center font-sans font-bold uppercase whitespace-nowrap select-none bg-yellow-400/20 text-yellow-600 py-1 px-2 text-xs rounded-md"
                                            style="opacity: 1;">
                                            <span class="text-center">On Going</span>
                                        </div>
                                    </template>
                                    <template x-if="project.status == 'completed'">
                                        <div class="scale-[80%] relative grid items-center font-sans font-bold uppercase whitespace-nowrap select-none bg-green-400/20 text-green-600 py-1 px-2 text-xs rounded-md"
                                            style="opacity: 1;">
                                            <span class="text-center">Completed</span>
                                        </div>
                                    </template>
                                </td>
                                <td>
                                    <div
                                        class="flex items-start justify-center antialiased font-sans text-sm leading-normal text-gray-900 font-normal">
                                        <template x-if="project.is_visible == 1">
                                            @svg('fluentui-checkmark-circle-24', 'w-5 h-5 text-green-500')
                                        </template>
                                        <template x-if="project.is_visible == 0">
                                            @svg('zondicon-close-solid', 'w-5 h-5 text-red-500')
                                        </template>
                                    </div>
                                </td>
                                <td>
                                    <div
                                        class="flex items-start justify-center antialiased font-sans text-sm leading-normal text-gray-900 font-normal">
                                        <template x-if="project.is_featured == 1">
                                            @svg('fluentui-checkmark-circle-24', 'w-5 h-5 text-green-500')
                                        </template>
                                        <template x-if="project.is_featured == 0">
                                            @svg('zondicon-close-solid', 'w-5 h-5 text-red-500')
                                        </template>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex gap-2 items-center justify-center">
                                        <x-public.button @click="$dispatch('openmodal', {
                                                modalID: 'modal_project',
                                                modal_header_text: 'Edit Project',
                                                special_data: {
                                                    product_data: project,
                                                }
                                            })" title="Edit data"
                                            class="cursor-pointer bg-blue-500 hover:bg-blue-600 active:bg-blue-400 transition-colors">
                                            @svg('fluentui-edit-24', 'w-4 h-4 text-white')
                                        </x-public.button>
                                        <x-public.button @click="$dispatch('openmodal', {
                                                modalID: 'modal_delete_project',
                                                modal_header_text: 'Delete Project?',
                                                special_data: {
                                                    product_data: project,
                                                }
                                            })" title="Delete data"
                                            class="cursor-pointer bg-red-500 hover:bg-red-600 active:bg-red-400 transition-colors">
                                            @svg('fluentui-delete-24', 'w-4 h-4 text-white')
                                        </x-public.button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 flex items-center justify-end gap-2">
            <div class="flex items-center justify-center gap-1 flex-wrap">
                <x-public.button x-bind:class="dataLoading ? 'disabled' : ''"
                    class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                    <span class="flex items-center justify-center gap-2">
                        @svg('fluentui-caret-left-24', 'w-6 h-6')
                        Previous
                    </span>
                </x-public.button>

                <template x-if="projectData && !dataLoading">
                    <div class="flex justify-center items-center gap-2 flex-wrap">
                        <template x-for="i in Array.from({ length: projectData.last_page }, (_, index) => index + 1)">
                            <x-public.button @click="changeSourceData(projectData.links[i].url)"
                                class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                                <span class="flex items-center justify-center" x-text="i"></span>
                            </x-public.button>
                        </template>
                    </div>
                </template>

                <x-public.button
                    class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                    <span class="flex items-center justify-center gap-2">
                        @svg('fluentui-caret-right-24', 'w-6 h-6')
                        Next
                    </span>
                </x-public.button>
            </div>
        </div>

    </section>


</div>

<x-layouts.modal modalID="modal_project" modalMaxWidth="4xl">
    <form @php
        $fileUploadId = 'file_upload_project';
    @endphp id="form_project" x-data="projectForm()"
        @submit.prevent="handleSubmit" 
        @modal_closed_fallback.window="handleModalClose($event)"
        @passed_product_data.window="loadProjectData($event);"
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
                                class="cursor-pointer w-5 h-5 border-2" />
                        </div>

                        <div class="flex flex-col gap-4">
                            <p class="text-sm font-medium flex">
                                Highlighted
                                <span class="ml-2" title="Will be shown in the homepage. (Max 3 projects)">
                                    @svg('fluentui-question-circle-24', 'w-4 h-4 text-gray-700')
                                </span>
                            </p>
                            <input name="highlighted" type="checkbox" @change="checkChanges()" {{--
                                x-model="projectData.is_featured" --}} :checked="Boolean(projectData.is_featured)"
                                class="cursor-pointer w-5 h-5 border-2" />
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
            <button type="button" @click="closeModal()" class="px-5 py-2 rounded bg-gray-300 hover:bg-gray-400">
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
        function projectForm() {
            return {
                loading: false,
                formDisabled: true,
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
                    this.formDisabled = true;
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
                    // if (this.formDisabled) {
                    //     toast("No changes to save.", "warning");
                    //     return;
                    // }

                    this.loading = true;
                    this.$el.submit();
                },
            };
        }
    </script>

</x-layouts.modal>

<x-layouts.modal modalID="modal_delete_project" modalMaxWidth="md">
    <section 
        x-data="deleteProjectForm()"
        @modal_closed_fallback.window="handleModalClose($event)"
        >
        <section>
            <h2>Project Info:</h2>

            <section class="p-2 bg-gray-200 rounded">
                <div class="flex gap-2">
                    <p class="font-bold">Job Order:</p>
                    <span x-text="projectData.job_order"></span>
                </div>
                <div class="flex gap-2">
                    <p class="font-bold">Title:</p>
                    <span x-text="projectData.title"></span>
                </div>
                <div class="flex gap-2">
                    <p class="font-bold">Status:</p>
                    <span x-text="projectData.status"></span>
                </div>
            </section>

        </section>
        <section>
            <form @passed_product_data.window="loadProjectData($event);" @submit.prevent="formSubmit()" method="POST"
                action="{{ route('content.delete.section.project') }}">
                @csrf
                <input type="hidden" name="project_id" x-bind:value="projectData.id" />
                <div class="mt-4 flex justify-end items-start gap-2">
                    <x-public.button type="button" button_type="default" @click="closeModal()">Cancel</x-public.button>
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
            function deleteProjectForm() {
                return {
                    projectData: {},
                    loading: false,
                    formDisabled: true,

                    formSubmit() {
                        this.loading = true;
                        this.$el.submit();
                    },

                    handleModalClose(e) {
                        if (e.detail.modalID !== this.modal_id) return;
                        this.projectData = {};
                        this.formDisabled = true;
                    },

                    loadProjectData(e) {
                        if (!e.detail.data) return;
                        if (e.detail.modalID !== this.modal_id) return;
                        this.projectData = e.detail.data.product_data;
                    },
                }
            }
        </script>
    </section>
</x-layouts.modal>