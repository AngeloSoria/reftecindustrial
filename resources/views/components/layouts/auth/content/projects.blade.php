<div>
    <section x-data="{
        checkboxActive: false,
        isAllRowsSelected: false,
        dataLoading: true,
        projectData: null,
        activeDataFromCheckbox: {},
        highlightedCount: 0,
        filters: {
            search: '',
            status: 'all',
            visibility: 'all',
            highlighted: 'all'
        },

        async init() {
            $watch('activeDataFromCheckbox', (e) => {
                this.checkboxActive = Object.keys(e).length > 0;
            });

            $watch('isAllRowsSelected', (value) => {
                document.querySelectorAll('.input_checkbox_item-project').forEach(el => {
                    el.checked = value;
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });

            this.applyFilters();
        },
        
        async changeSourceData(route) {
            if(!route) {
                // console.warn('No route passed when calling changeSourceData');
                return;
            }
            const response = await fetch(route);
            const data = await response.json();
            // console.log(data);
            if(data && data.success) {
                this.projectData = data.data;
                this.highlightedCount = data.featured;
                this.dataLoading = false;
            }

            // reset checkboxes
            this.isAllRowsSelected = false;
            this.activeDataFromCheckbox = {};
            document.querySelector('#input_checkbox_selectAll').checked = false;
            {{-- console.log(this.projectData); --}}
        },
        async applyFilters(page = 1) {
            this.dataLoading = true;

            // Build query string
            const params = new URLSearchParams();

            if (this.filters.search) params.append('search', this.filters.search);
            if (this.filters.status && this.filters.status !== 'all') params.append('status', this.filters.status);
            if (this.filters.visibility && this.filters.visibility !== 'all') {
                params.append('visibility', this.filters.visibility === 'visible' ? 1 : 0);
            }
            if (this.filters.highlighted && this.filters.highlighted !== 'all') {
                params.append('featured', this.filters.highlighted === 'true' ? 1 : 0);
            }

            params.append('page', page);

            const url = `{{ route('content.get.section.projects.filtered') }}?${params.toString()}`;
            await this.changeSourceData(url);
        },
        paginationRange() {
            if (!this.projectData || !this.projectData.last_page) return [];

            const total = this.projectData.last_page;
            const current = this.projectData.current_page;
            const delta = 2;
            const range = [];

            range.push(1);

            let left = Math.max(2, current - delta);
            let right = Math.min(total - 1, current + delta);

            if (left > 2) {
                range.push('...');
            }

            for (let i = left; i <= right; i++) {
                range.push(i);
            }

            if (right < total - 1) {
                range.push('...');
            }

            if (total > 1) {
                range.push(total);
            }

            return range;
        },
        checkboxDataSelected(projectData, isChecked) {
            if (projectData === undefined) { return; }
            if (isChecked) {
                this.activeDataFromCheckbox[projectData.id] = projectData;
            } else {
                delete this.activeDataFromCheckbox[projectData.id];
            }
        }
    }">
        <div class="p-2 flex items-center justify-end gap-3 flex-wrap mt-4">
            <x-public.button @click="$dispatch('openmodal', {
                modalID: 'modal_project',
                title: 'Add Project'
            })" button_type="primary">
                <span class="flex items-center justify-center gap-2">
                    @svg('fluentui-add-circle-24-o', 'w-5 h-5')
                    Add New Project
                </span>
            </x-public.button>

            <div x-transition x-show="checkboxActive" class="flex items-start justify-center">
                <x-public.button x-data @click="
                        if (Object.keys(activeDataFromCheckbox).length < 0) { return }
                        $dispatch('openmodal', {
                            modalID: 'modal_delete_projects',
                            title: 'Delete this projects?',
                            payload_data: {
                                project_data: activeDataFromCheckbox
                            }
                        });
                    " size="sm" class="bg-red-500 hover:bg-red-400 transition-colors cursor-pointer">
                    <span class="flex items-center justify-center gap-2">
                        @svg('fluentui-delete-28-o', 'w-5 h-5')
                        Delete Selected <span x-text="'(' + Object.keys(activeDataFromCheckbox).length + ')'"></span>
                    </span>
                </x-public.button>
            </div>

            <div class="cursor-pointer relative p-1 rounded bg-white shadow-card border border-transparent hover:border-accent-darkslategray-200/50 transition-colors"
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
                    class="min-w-sm max-w-md absolute bottom-0 right-0 translate-y-[100%] bg-white p-2 rounded shadow-card z-[10]">
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

        {{-- Filter --}}
        <div class="flex items-start justify-end gap-3 mt-2 mb-3">
            <section class="flex flex-col gap-1">
                <p class="text-xxs font-sans font-medium text-black/50">SEARCH</p>
                <div
                    class="max-h-[42px] rounded-sm shadow-card md:min-w-[200px] flex items-center justify-start focus-within:bg-accent-darkslategray-400/30 transition-colors">
                    <div title="Search"
                        class="h-full py-2 px-3 grid items-center bg-transparent hover:bg-accent-darkslategray-100 transition-colors cursor-pointer rounded-tl-sm rounded-bl-sm">
                        @svg('fluentui-search-12', 'w-4 h-4 text-black/60')
                    </div>
                    <input type="text" placeholder="Search projects..." x-model="filters.search"
                        @input.debounce.300ms="applyFilters" class="h-full rounded-sm outline-none grow ps-2">
                </div>
            </section>
            <section class="flex flex-col gap-1">
                <p class="text-xxs font-sans font-medium text-black/50">STATUS</p>
                <select x-model="filters.status" @change="applyFilters"
                    class="max-h-[42px] px-2 py-1 rounded-sm shadow-card md:min-w-[200px]">
                    <option value="all" selected>All</option>
                    <option value="on_going">On Going</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
            </section>
            <section class="flex flex-col gap-1">
                <p class="text-xxs font-sans font-medium text-black/50">VISIBILITY</p>
                <select x-model="filters.visibility" @change="applyFilters"
                    class="max-h-[42px] px-2 py-1 rounded-sm shadow-card md:min-w-[100px]">
                    <option value="all" selected>All</option>
                    <option value="visible">Visible</option>
                    <option value="hidden">Hidden</option>
                </select>
            </section>
            <section class="flex flex-col gap-1">
                <p class="text-xxs font-sans font-medium text-black/50">HIGHLIGHTS</p>
                <select x-model="filters.highlighted" @change="applyFilters"
                    class="max-h-[42px] px-2 py-1 rounded-sm shadow-card md:min-w-[100px]">
                    <option value="all" selected>All</option>
                    <option value="true">Highlighted</option>
                    <option value="false">Non Highlighted</option>
                </select>
            </section>
        </div>

        {{-- Table --}}
        <div class="overflow-auto rounded max-h-[600px] overflow-y-auto">
            <table class="w-full min-w-max table-auto text-left rounded-t-md">
                <thead>
                    <tr
                        class="bg-royalblue-400/50 shadow-sm [&>*:first-child]:rounded-tl-sm [&>*:last-child]:rounded-tr-sm [&>*]:border-x [&>*]:border-gray-200 [&>*]:p-4">

                        <th class="rounded-tl-md">
                            <input x-data="{
                                    titleContent: 'Select All'
                                }" @change="
                                    titleContent = $event.target.checked ? 'Deselect All' : 'Select All';
                                    isAllRowsSelected = $event.target.checked;
                                " x-bind:disabled="dataLoading" type="checkbox" id="input_checkbox_selectAll"
                                x-bind:title="titleContent"
                                class="m-auto cursor-pointer w-5 h-5 text-accent-orange-300 accent-orange-400 rounded-sm" />
                        </th>

                        <th>
                            <p class="font-normal text-sm text-center">#</p>
                        </th>

                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 font-normal leading-none">
                                Images
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 font-normal leading-none">
                                Job Order
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 font-normal leading-none">
                                Title
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 font-normal leading-none">
                                Description
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 text-center font-normal leading-none mx-auto">
                                Status
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-gray-900 font-normal leading-none">
                                Visible
                            </p>
                        </th>
                        <th>
                            <p
                                x-text="`Highlighted (${highlightedCount}/3)`"
                                class="antialiased font-sans text-sm text-gray-900 font-normal leading-none">
                                Highlight (#/3)
                            </p>
                        </th>
                        <th>
                            <p
                                class="antialiased font-sans text-sm text-center text-gray-900 gap-2 font-normal leading-none">
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
                            <tr x-data="{
                                    isRowActive: false,
                                }"
                                x-bind:class="isRowActive ? 'bg-accent-orange-400/35' : '*:bg-accent-darkslategray-50'"
                                class="*:p-2 *:border-b *:border-gray-300/50 transition-colors">
                                <td>
                                    <div class="p-2">
                                        <input x-bind:value="project.id" x-bind:checked="isAllRowsSelected" @change="
                                        checkboxDataSelected(project, $event.target.checked);
                                            isRowActive = $event.target.checked;
                                            " x-bind:value="project.id" type="checkbox"
                                            class="input_checkbox_item-project cursor-pointer w-5 h-5 mx-auto text-accent-orange-300 accent-orange-400 rounded-sm border-2 border-accent-darkslategray-700" />
                                    </div>
                                </td>
                                <td>
                                    <span x-text="projectData.from + index" class="text-center text-sm"></span>
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
                                                    x-bind:alt="image_path"
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
                                        <p class="block antialiased font-sans font-medium text-sm leading-normal text-gray-900"
                                            x-text="project.title.length > 40 ? project.title.substring(0, 40) + '...' : project.title"></p>
                                    </div>
                                </td>
                                <td>
                                    <div class="w-max overflow-x-auto max-w-[200px] whitespace-normal break-words">
                                        <p class="block antialiased font-sans text-sm leading-normal text-gray-900 font-normal"
                                            x-text="project.description.length > 50 ? project.description.substring(0, 50) + '...' : project.description">
                                            </p>
                                    </div>
                                </td>
                                <td>
                                    <template x-if="project.status == 'pending'">
                                        <div class="max-w-fit mx-auto relative grid items-center font-sans font-medium uppercase whitespace-nowrap select-none bg-orange-400/15 text-orange-600 py-1 px-2 text-xs rounded-full"
                                            style="opacity: 1;">
                                            <span class="text-center">Pending</span>
                                        </div>
                                    </template>
                                    <template x-if="project.status == 'on_going'">
                                        <div class="max-w-fit mx-auto relative grid items-center font-sans font-medium uppercase whitespace-nowrap select-none bg-yellow-400/15 text-yellow-600 py-1 px-2 text-xs rounded-full"
                                            style="opacity: 1;">
                                            <span class="text-center">On Going</span>
                                        </div>
                                    </template>
                                    <template x-if="project.status == 'completed'">
                                        <div class="max-w-fit mx-auto relative grid items-center font-sans font-medium uppercase whitespace-nowrap select-none bg-green-400/15 text-green-600 py-1 px-2 text-xs rounded-full"
                                            style="opacity: 1;">
                                            <span class="text-center">Completed</span>
                                        </div>
                                    </template>
                                </td>
                                <td>
                                    <div
                                        class="flex items-start justify-center antialiased font-sans text-sm leading-normal text-gray-900 font-normal">
                                        <template x-if="project.is_visible == 1">
                                            <span title="Visible to public">
                                                @svg('fluentui-eye-24-o', 'w-5 h-5 text-gray-500')
                                            </span>
                                        </template>
                                        <template x-if="project.is_visible == 0">
                                            <span title="Hidden to public">
                                                @svg('fluentui-eye-off-24-o', 'w-5 h-5 text-gray-500')
                                            </span>
                                        </template>
                                    </div>
                                </td>
                                <td>
                                    <div
                                        class="flex items-start justify-center antialiased font-sans text-sm leading-normal text-gray-900 font-normal">
                                        <template x-if="project.is_featured == 1">
                                            <div
                                                title="Featured to homepage" 
                                                class="rounded-full p-2 grid items-center bg-yellow-400/30">
                                                @svg('fluentui-star-12-o', 'w-4 h-4 text-gray-600')
                                            </div>
                                        </template>
                                        <template x-if="project.is_featured == 0">
                                            <div
                                                class="rounded-full p-2 grid items-center bg-transparent">
                                                @svg('fluentui-star-12-o', 'w-4 h-4 text-gray-600')
                                            </div>
                                        </template>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex gap-2 items-center justify-center">
                                        <button @click="$dispatch('openmodal', {
                                                modalID: 'modal_project',
                                                title: 'Edit Project',
                                                payload_data: {
                                                    product_data: project,
                                                }
                                            })" title="Edit data"
                                            class="cursor-pointer p-2 rounded-sm bg-blue-500 hover:bg-blue-600 active:bg-blue-400 transition-colors">
                                            @svg('fluentui-edit-24-o', 'w-4 h-4 text-white')
                                        </button>
                                        <button @click="$dispatch('openmodal', {
                                                modalID: 'modal_delete_project',
                                                title: 'Delete Project?',
                                                payload_data: {
                                                    product_data: project,
                                                }
                                            })" title="Delete data"
                                            class="cursor-pointer p-2 rounded-sm bg-red-500/15 hover:bg-red-500/20 active:bg-red-500/10 transition-colors">
                                            @svg('fluentui-delete-24', 'w-4 h-4 text-red-500')
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <template x-if="projectData && !dataLoading">
            <div class="mt-4 flex items-center justify-between gap-2">
                <section>
                    <p class="text-sm font-medium text-gray-700">
                        Showing
                        <span class="font-bold" x-text="projectData.from"></span>
                        to
                        <span class="font-bold" x-text="projectData.to"></span>
                        of
                        <span class="font-bold" x-text="projectData.total"></span>
                        projects
                    </p>
                </section>
                <section class="flex items-center justify-center gap-1 flex-wrap">
                    <!-- Previous Button -->
                    <x-public.button @click="applyFilters(projectData.current_page - 1)"
                        x-bind:disabled="!projectData.prev_page_url"
                        class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                        <span class="flex items-center justify-center gap-2">
                            @svg('fluentui-caret-left-24', 'w-6 h-6')
                            Previous
                        </span>
                    </x-public.button>

                    <!-- Page Numbers -->
                    <div class="flex justify-center items-center gap-2 flex-wrap">
                        <template x-for="(page, index) in paginationRange()" :key="page + '_' + index">
                            <x-public.button @click="page !== '...' && applyFilters(page)"
                                x-bind:class="page === projectData.current_page ? 'bg-brand-primary-600 text-white' : 'bg-white border'"
                                class="px-3 py-1 rounded border cursor-pointer" x-text="page">
                            </x-public.button>
                        </template>
                    </div>

                    <!-- Next Button -->
                    <x-public.button @click="applyFilters(projectData.current_page + 1)"
                        x-bind:disabled="!projectData.next_page_url"
                        class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                        <span class="flex items-center justify-center gap-2">
                            @svg('fluentui-caret-right-24', 'w-6 h-6')
                            Next
                        </span>
                    </x-public.button>

                </section>
            </div>
        </template>

        <x-auth.content.project.modal_add_edit_project />
        <x-auth.content.project.modal_delete_project />
        <x-auth.content.project.modal_delete_selected_project />
    </section>
</div>