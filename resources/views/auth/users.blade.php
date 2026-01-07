<x-layouts.auth.app viewName="Users">
    <div
        class="bg-white shadow-md rounded-xl min-h-[calc(100vh - var(--topbar_force_style))] my-2 mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h2>Users List</h2>
        <div x-data="UserHandler()" class="pt-4">
            <section>
                <div class="p-2 flex items-center justify-end gap-3 flex-wrap mt-4">
                    <x-public.button @click="$dispatch('openmodal', {
                        modalID: 'modal_user_register',
                        modal_header_text: 'Register User Form'
                    })" button_type="primary">
                        <span class="flex items-center justify-center gap-2">
                            @svg('fluentui-add-circle-24-o', 'w-5 h-5')
                            Register New User
                        </span>
                    </x-public.button>

                    {{-- <div class="cursor-pointer relative p-1 rounded bg-white shadow-card border border-transparent hover:border-accent-darkslategray-200/50 transition-colors"
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
                    </div> --}}
                </div>

                {{-- filter --}}
                <div class="flex items-start justify-end gap-3 mt-2 mb-3">
                    <section class="flex flex-col gap-1">
                        <p class="text-xxs font-sans font-medium text-black/50">SEARCH</p>
                        <div
                            class="max-h-[42px] rounded-sm shadow-card md:min-w-[200px] flex items-center justify-start focus-within:bg-accent-darkslategray-400/30 transition-colors">
                            <div title="Search"
                                class="h-full py-2 px-3 grid items-center bg-transparent hover:bg-accent-darkslategray-100 transition-colors cursor-pointer rounded-tl-sm rounded-bl-sm">
                                @svg('fluentui-search-12', 'w-4 h-4 text-black/60')
                            </div>
                            <input x-bind:disabled="!dataLoaded" type="text" placeholder="Search users..." x-model="filters.search"
                                @input.debounce.400ms="applyFilters" class="h-full rounded-sm outline-none grow ps-2">
                        </div>
                    </section>
                    <section class="flex flex-col gap-1">
                        <p class="text-xxs font-sans font-medium text-black/50">ROLE</p>
                        <select x-bind:disabled="!dataLoaded" x-model="filters.role" @change="applyFilters"
                            class="max-h-[42px] px-2 py-1 rounded-sm shadow-card md:min-w-[100px]">
                            <option value="all" selected>All</option>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </section>
                </div>
            </section>

            {{-- Skeleton loading --}}
            <template x-if="!dataLoaded">
                <section class="grid gap-3 grid-cols-2 sm:grid-cols-3 md:grid-cols-4">
                    <template x-for="n in 11" :key="n">
                        <div class="bg-gray-300 shadow-card rounded-md px-6 py-12 animate-pulse flex flex-col gap-3">
                            <div class="rounded-full p-1 max-w-[85%] bg-gray-400 animate-pulse"></div>
                            <div class="rounded-full p-1 max-w-[55%] bg-gray-400 animate-pulse"></div>
                            <div class="rounded-full p-1 max-w-[35%] bg-gray-400 animate-pulse"></div>
                        </div>
                    </template>
                </section>
            </template>

            <template x-if="dataLoaded">
                <div>
                    <section class="grid gap-3 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                        <template x-for="user in users.data">
                            <div
                                x-data="{
                                    isHovered: false,
                                }"
                                @mouseover="isHovered = true"
                                @mouseleave="isHovered = false"
                                class="relative">
                                {{-- widget tools --}}
                                <div
                                    x-transition
                                    x-show="isHovered"
                                    class="absolute top-2 right-2 flex justify-end items-start gap-3">
                                    <button
                                        @click="$dispatch('openmodal', {
                                            modalID: 'modal_user_update',
                                            modal_header_text: 'Update User',
                                            special_data: {
                                                user_data: user,
                                            }
                                        })"
                                        title="Update User"
                                        class="bg-white rounded-full p-2 shadow-md hover:shadow-xl transition-all outline outline-gray-200 cursor-pointer">
                                        @svg('fluentui-person-edit-20-o', 'w-6 h-6 text-blue-400')
                                    </button>
                                    <button
                                        @click="$dispatch('openmodal', {
                                            modalID: 'modal_user_remove',
                                            modal_header_text: 'Remove User?',
                                            special_data: {
                                                user_data: user,
                                            }
                                        })"
                                        title="Delete User"
                                        class="bg-white rounded-full p-2 shadow-md hover:shadow-xl transition-all outline outline-gray-200 cursor-pointer">
                                        @svg('fluentui-delete-20-o', 'w-6 h-6 text-red-400')
                                    </button>
                                </div>
                                <div
                                    :class="isHovered ? 'outline-2 outline-gray-300' : ''"
                                    class="bg-gray-100 shadow-card rounded-md p-4 flex gap-2 overflow-hidden">
                                    <div>
                                        <div class="p-2 rounded-full border border-gray-300">
                                            <span>
                                                @svg('fluentui-person-20', 'text-black/50 w-5 h-5')
                                            </span>
                                        </div>
                                    </div>
                                    <div class="grow">
                                        <p x-text="user.name" class="text-xl font-semibold"></p>
                                        <p x-text="user.username" class="text-lg opacity-[75%]"></p>
                                        <div :class="user.role == 'Super Admin' ? 'text-red-500 border-red-500' : 'text-orange-400 border-orange-400'"
                                            class="mt-2 py-1 px-3 rounded-full text-xs font-medium max-w-fit border">
                                            <span x-text="user.role"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </section>
                    {{-- Pagination --}}
                    <div class="mt-4 flex items-center justify-between gap-2">
                        <section>
                            <p class="text-sm font-medium text-gray-700">
                                Showing
                                <span class="font-bold" x-text="users.from"></span>
                                to
                                <span class="font-bold" x-text="users.to"></span>
                                of
                                <span class="font-bold" x-text="users.total"></span>
                                products
                            </p>
                        </section>
                        <section class="flex items-center justify-center gap-1 flex-wrap">
                            <!-- Previous Button -->
                            <x-public.button @click="applyFilters(users.current_page - 1)"
                                x-bind:disabled="!users.prev_page_url"
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
                                        x-bind:class="page === users.current_page ? 'bg-brand-primary-600 text-white' : 'bg-white border'"
                                        class="px-3 py-1 rounded border cursor-pointer" x-text="page">
                                    </x-public.button>
                                </template>
                            </div>

                            <!-- Next Button -->
                            <x-public.button @click="applyFilters(users.current_page + 1)"
                                x-bind:disabled="!users.next_page_url"
                                class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                                <span class="flex items-center justify-center gap-2">
                                    @svg('fluentui-caret-right-24', 'w-6 h-6')
                                    Next
                                </span>
                            </x-public.button>

                        </section>
                    </div>
                </div>
            </template>

        </div>
        <script>
            function UserHandler() {
                return {
                    users: null,
                    dataLoaded: false,
                    filters: {
                        search: '',
                        role: 'all',
                    },
                    async init() {
                        const response = await fetch('{{ route('user.get.all') }}');
                        const data = await response.json();

                        if (data && data.success) {
                            this.users = data.data;
                            this.dataLoaded = true;
                        }
                        console.log(this.users);
                    },
                    async changeSourceData(route) {
                        if (!route) {
                            console.warn('No route passed when calling changeSourceData');
                            return;
                        }
                        this.dataLoaded = false;
                        const response = await fetch(route);
                        const data = await response.json();
                        if (data && data.success) {
                            this.users = data.data;
                            this.dataLoaded = true;
                        }
                        console.log(route)
                    },
                    async applyFilters(page = 1) {
                        this.dataLoading = true;

                        // Build query string
                        const params = new URLSearchParams();

                        console.log(this.filters);

                        if (this.filters.search) params.append('search', this.filters.search);
                        if (this.filters.role && this.filters.role !== 'all') params.append('role', this.filters.role);

                        params.append('page', page);

                        console.log(params.toString());

                        const url = `{{ route('user.get.all') }}?${params.toString()}`;
                        await this.changeSourceData(url);
                    },
                    paginationRange() {
                        if (!this.users || !this.users.last_page) return [];

                        const total = this.users.last_page;
                        const current = this.users.current_page;
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
                }
            }
        </script>
    </div>

    <x-layouts.auth.user.register />
    <x-layouts.auth.user.delete />
    <x-layouts.auth.user.update />
</x-layouts.auth.app>