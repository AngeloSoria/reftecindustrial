<div>
    <h3 class="text-lg font-medium text-gray-900">Projects</h3>
    <p class="mt-2 text-sm text-gray-500">This is the projects content section. Display project-related information
        here.</p>
    <!-- Add more content as needed -->

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
                                        <div class="grid grid-cols-2 grid-rows-3 gap-1">
                                            <template x-for="image_path in project.images" :key="image_path + '_' + crypto.randomUUID()">
                                                <img x-data
                                                    @click="$dispatch('image_preview_event', { previewInfo: { image: $el.src }}); console.log(123)"
                                                    x-bind:src="image_path"
                                                    class="max-w-[60px] aspect-video rounded cursor-pointer brightness-75 hover:brightness-100 transition-all" />
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
                                    <div class="w-max overflow-x-auto max-w-3xs whitespace-normal break-words">
                                        <p class="block antialiased font-sans text-sm leading-normal text-gray-900 font-normal"
                                            x-text="project.title"></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="w-max overflow-x-auto max-w-3xs whitespace-normal break-words">
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
                                        <x-public.button title="Edit data"
                                            class="cursor-pointer bg-blue-500 hover:bg-blue-600 active:bg-blue-400 transition-colors">
                                            @svg('fluentui-edit-24', 'w-4 h-4 text-white')
                                        </x-public.button>
                                        <x-public.button title="Delete data"
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

<x-layouts.modal modalID="modal_project" modalMaxWidth="2xl">

    <form
        @php
            $fileUploadId = 'file_upload_project';
        @endphp
    id="form_project"
    x-data="{
        loading: false,
        formDisabled: true,
        modal_id: 'modal_project',
        file_upload_id: @js($fileUploadId),
        projectData: {},
        routes: {
            add: '{{ route('content.add.section.project') }}',
            edit: '{{ route('content.add.section.project') }}',
        },

        async init() {

        },
    }"
    @submit.prevent="
        loading = true;
        if(formDisabled) {
            toast('all required fields in the form must have value first.', 'warning');
            return;
        }
        $dispatch('form_in_submit_phase', { file_upload_id: file_upload_id });
        $el.submit();
    "
    @modal_closed_fallback.window="
        if($event.detail.modalID !== modal_id ) { return }
        $dispatch('reset_file_upload', { file_upload_id: file_upload_id });
    "
    @passed_product_data.window="
        if (!$event.detail.data) { console.error('No data passed.') }
        if (!event.detail.modalID) { console.error('No modal ID passed. \n modal_id: ' + modal_id); }
        if ($event.detail.modalID !== modal_id) { return }
        productData = $event.detail.data.product_data;
        if(productData.visibility) {
            productData.visibility = productData.visibility == 1 ? true : false;
        }
        productData.image_required = productData.image_path ? false : true;
    "
    @files_empty.window="
        if($event.detail.file_upload_id != file_upload_id) return;
        formDisabled = true;
    " @files_not_empty.window="
        if($event.detail.file_upload_id != file_upload_id) return;
        formDisabled = false; 
    "
    method="POST"
    x-bind:action="Object.keys(projectData).length > 0 && projectData.id ? routes.edit : routes.add"
    enctype="multipart/form-data"
    >
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-2 items-start justify-start">
                <p for="input_productLineName" class="text-sm font-medium">
                    Job Order
                    <span class="text-red-500 font-bold">*</span>
                </p>
                <input
                    class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                    id="input_jobOrder" name="job_order" type="text" placeholder="Enter job order number..." required
                    aria-required="true" />
            </div>
            <div class="flex flex-col gap-2 items-start justify-start">
                <p for="input_productLineName" class="text-sm font-medium">
                    Project Name
                    <span class="text-red-500 font-bold">*</span>
                </p>
                <input
                    class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                    id="input_projectName" name="project_name" type="text" placeholder="Enter project name..." required
                    aria-required="true" />
            </div>
        </div>

        <div class="mt-4">
            <div class="flex flex-col gap-2 items-start justify-start">
                <p class="text-sm font-medium">
                    Description
                    {{-- <span class="text-red-500 font-bold">*</span> --}}
                </p>
                <textarea id="input_description" name="description" form="form_project" aria-required="true" required
                    placeholder="Enter project description..."
                    class="w-full min-h-34 max-h-40 px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"></textarea>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-2 items-start justify-start">
                <p for="input_productLineName" class="text-sm font-medium">
                    Status
                    <span class="text-red-500 font-bold">*</span>
                </p>
                <select
                    class="w-full px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none focus:bg-gray-200 transition-colors"
                    name="status" type="text" required aria-required="true">
                    <option disabled selected>Select status...</option>
                    <option value="pending">Pending</option>
                    <option value="on_going">On Going</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-2 items-start">
                <div class="flex flex-col gap-4">
                    <p for="input_productLineName" class="text-sm font-medium">
                        Visible to public
                    </p>
                    <input
                        name="visiblility"
                        class="cursor-pointer w-5 h-5 text-accent-orange-300 accent-orange-400 rounded-sm border-2 border-accent-darkslategray-700"
                        type="checkbox" />
                </div>
                <div class="flex flex-col gap-4">
                    <p for="input_productLineName" class="text-sm font-medium flex">
                        Highlighted
                        <span class="ml-2" title="Will be shown in the homepage. (Max 3 projects)">
                            @svg('fluentui-question-circle-24', 'w-4 h-4 text-gray-700')
                        </span>
                    </p>
                    <input 
                        type="checkbox"
                        name="highlighted"
                        class="cursor-pointer w-5 h-5 text-accent-orange-300 accent-orange-400 rounded-sm border-2 border-accent-darkslategray-700" />
                </div>
            </div>
        </div>

        <div class="mt-4 w-full flex flex-col gap-1">
            <label class="text-sm font-medium">

                <span>
                    Images
                    <span class="text-red-500 font-bold">*</span>
                </span>

            </label>
            <x-layouts.file_upload_drag acceptFile="image/*" file_upload_id="file_upload_project" maxUploadCount="6" multiple />
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