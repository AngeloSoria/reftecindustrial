<x-layouts.auth.app viewName="Logs" class="">
    <div
        class="bg-white shadow-md rounded-xl min-h-[calc(100vh - var(--topbar_force_style))] my-2 mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl">Activity Log</h2>
        <h2 class="text-gray-500 text-md">Track user activity, including actions, timestamps, user, and details.</h2>

        {{-- table --}}
        <section x-data="activityLogHandler()" class="my-4">

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
                        <input type="text" placeholder="Search logs..." x-model="filters.search"
                            @input.debounce.300ms="applyFilters" class="h-full rounded-sm outline-none grow ps-2">
                    </div>
                </section>
                <section class="flex flex-col gap-1">
                    <p class="text-xxs font-sans font-medium text-black/50">ACTION</p>
                    <select x-model="filters.action" @change="applyFilters"
                        class="max-h-[42px] px-2 py-1 rounded-sm shadow-card md:min-w-[100px]">
                        <option value="all" selected>All</option>
                        <option value="create">Create</option>
                        <option value="read">Read</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                    </select>
                </section>
                <section class="flex flex-col gap-1">
                    <p class="text-xxs font-sans font-medium text-black/50">DATE</p>
                    <input x-model="filters.datetime" @change="applyFilters" type="date"
                        class="max-h-[42px] px-2 py-1 rounded-sm shadow-card md:min-w-[100px]" />
                </section>
            </div>

            <table class="table-auto w-full">
                <colgroup>
                    <col class="w-[10%]" />
                    <col class="w-[20%]" />
                    <col class="w-[15%]" />
                    <col class="w-[20%]" />
                    <col class="w-auto" />
                </colgroup>
                <thead>
                    <tr class="
                        *:p-2
                        *:border-b
                        *:border-b-black/15
                        *:font-semibold
                        *:text-gray-600
                    ">
                        <th class="text-start">Action</th>
                        <th class="text-start">Activity</th>
                        <th class="text-start">Timestamp</th>
                        <th class="text-start">User</th>
                        <th class="text-start">Details</th>
                    </tr>
                </thead>
                <tbody x-data>
                    {{-- Loading skeleton --}}
                    <template x-if="!dataLoaded">
                        <template x-for="n in 6" :key="n">
                            <tr class="
                                *:px-2
                                *:py-4
                                *:border-b
                                *:border-b-black/15
                                *:font-thin
                                bg-gray-300
                                animate-pulse
                            ">
                                <td>
                                    <div class="bg-gray-400 rounded-full p-1 w-[75%] animate-pulse"></div>
                                </td>
                                <td>
                                    <div class="bg-gray-400 rounded-full p-1 w-[75%] animate-pulse"></div>
                                </td>
                                <td>
                                    <div class="bg-gray-400 rounded-full p-1 w-[55%] animate-pulse"></div>
                                </td>
                                <td>
                                    <div class="bg-gray-400 rounded-full p-1 w-[65%] animate-pulse"></div>
                                </td>
                                <td>
                                    <div class="bg-gray-400 rounded-full p-1 w-[75%] animate-pulse"></div>
                                    <div class="mt-3 bg-gray-400 rounded-full p-1 w-[50%] animate-pulse"></div>
                                </td>
                            </tr>
                        </template>
                    </template>


                    <template x-if="dataLoaded">
                        <template x-if="Object.keys(activityLogsData.data).length > 0">
                            {{-- Data rows --}}
                            <template x-for="(log, index) in activityLogsData.data" :key="index">
                                <tr class="*:p-2 *:border-b *:border-b-black/15 *:font-thin *:text-sm">
                                    <td>
                                        <div
                                            x-data="{
                                                actionStyle: {
                                                    undefined:  'text-white bg-gray-400/50',
                                                    create:     'text-green-800 bg-green-500/50',
                                                    read:       'text-blue-600 bg-blue-500/50',
                                                    update:     'text-yellow-600 bg-yellow-500/50',
                                                    delete:     'text-red-600 bg-red-500/50',
                                                },
                                                actionColor: null,
                                                init() {
                                                    if (!log.action) this.actionColor = this.actionStyle['default'];
                                                    this.actionColor = this.actionStyle[log.action];
                                                },
                                            }"
                                            class="flex items-center justify-start gap-1">
                                            <span
                                                :class="actionColor"
                                                class="px-2 py-1 rounded-sm text-center uppercase font-medium text-xs">
                                                <p x-text="log.action"></p>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-start gap-1">
                                            <p x-text="log.activity"></p>
                                        </div>
                                    </td>
                                    <td>
                                        <span x-text="formatDate(log.created_at)"></span>
                                    </td>
                                    <td x-text="log.user"></td>
                                    <td x-text="log.details"></td>
                                </tr>
                            </template>
                        </template>
                    </template>

                </tbody>
            </table>

            {{-- Pagination --}}
            <template x-if="activityLogsData && dataLoaded">
                <div class="mt-4 flex items-center justify-between gap-2">
                    <section>
                        <p class="text-sm font-medium text-gray-700">
                            Showing
                            <span class="font-bold" x-text="activityLogsData.from"></span>
                            to
                            <span class="font-bold" x-text="activityLogsData.to"></span>
                            of
                            <span class="font-bold" x-text="activityLogsData.total"></span>
                            activity logs
                        </p>
                    </section>
                    <section class="flex items-center justify-center gap-1 flex-wrap">
                        <!-- Previous Button -->
                        <x-public.button @click="applyFilters(activityLogsData.current_page - 1)"
                            x-bind:disabled="!activityLogsData.prev_page_url"
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
                                    x-bind:class="page === activityLogsData.current_page ? 'bg-brand-primary-600 text-white' : 'bg-white border'"
                                    class="px-3 py-1 rounded border cursor-pointer" x-text="page">
                                </x-public.button>
                            </template>
                        </div>

                        <!-- Next Button -->
                        <x-public.button @click="applyFilters(activityLogsData.current_page + 1)"
                            x-bind:disabled="!activityLogsData.next_page_url"
                            class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                            <span class="flex items-center justify-center gap-2">
                                @svg('fluentui-caret-right-24', 'w-6 h-6')
                                Next
                            </span>
                        </x-public.button>

                    </section>
                </div>
            </template>

            <script>
                function activityLogHandler() {
                    return {
                        activityLogsData: null,
                        dataLoaded: false,
                        filters: {
                            search: '',
                            action: '',
                            datetime: '',
                        },

                        async init() {
                            const response = await fetch('{{ route('logs.get.all') }}');
                            const data = await response.json();

                            if (data && data['success']) {
                                this.activityLogsData = data.data;
                                this.dataLoaded = true;
                            }
                        },

                        async changeSourceData(route) {
                            if (!route) {
                                return;
                            }
                            const response = await fetch(route);
                            const data = await response.json();
                            if (data && data.success) {
                                this.activityLogsData = data.data;
                                this.dataLoaded = true;
                            }
                        },

                        async applyFilters(page = 1) {
                            this.dataLoaded = false;

                            // Build query string
                            const params = new URLSearchParams();

                            if (this.filters.search) params.append('search', this.filters.search);
                            if (this.filters.action && this.filters.action !== 'all') {
                                params.append('action', this.filters.action);
                            }
                            if (this.filters.datetime) {
                                params.append('datetime', this.filters.datetime);
                            }

                            params.append('page', 1);

                            const url = `{{ route('logs.get.all') }}?${params.toString()}`;
                            await this.changeSourceData(url);
                        },

                        paginationRange() {
                            if (!this.activityLogsData || !this.activityLogsData.last_page) return [];

                            const total = this.activityLogsData.last_page;
                            const current = this.activityLogsData.current_page;
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

                        formatDate(value) {
                            const date = new Date(value);

                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const day = String(date.getDate()).padStart(2, '0');
                            const year = date.getFullYear();

                            let hours = date.getHours();
                            const mins = String(date.getMinutes()).padStart(2, '0');
                            const secs = String(date.getSeconds()).padStart(2, '0');

                            const ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12 || 12;

                            return `${month}/${day}/${year} ${hours}:${mins}:${secs} ${ampm}`;
                        },
                    };
                }
            </script>

        </section>
    </div>
</x-layouts.auth.app>