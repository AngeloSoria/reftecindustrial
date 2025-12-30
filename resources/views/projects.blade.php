<!DOCTYPE html>
<html lang="en">
<x-partials.head />

<body class="bg-white">
    <x-public.navbar />

    <x-public.content_container>
        <section x-data="{
                projectsData: null,
                dataLoading: true,
                filters: {
                    search: '',
                    status: 'all',
                },
                async init() {
                    // Fetch projects data from an API endpoint
                    try {
                        const response = await fetch('{{ route('content.get.section.projects.filtered.public') }}');
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        const result = await response.json();
                        if (result.success) {
                            this.projectsData = result.data;
                            this.dataLoading = false;
                            console.log(this.projectsData);
                        } else {
                            console.error('Failed to load projects data:', result.message);
                        }
                    } catch (error) {
                        console.error('Error fetching projects data:', error);
                    }
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
                        this.projectsData = data.data;
                        this.dataLoading = false;
                    }
                },

                paginationRange() {
                    if (!this.projectsData || !this.projectsData.last_page) return [];

                    const total = this.projectsData.last_page;
                    const current = this.projectsData.current_page;
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

                async applyFilters(page = 1) {
                    this.dataLoading = true;

                    // Build query string
                    const params = new URLSearchParams();

                    if (this.filters.search) params.append('search', this.filters.search);
                    if (this.filters.status && this.filters.status !== 'all') params.append('status', this.filters.status);

                    params.append('page', page);

                    const url = `{{ route('content.get.section.projects.filtered.public') }}?${params.toString()}`;
                    await this.changeSourceData(url);
                },
                
            }">
            <div class="flex flex-col items-center justify-center my-12">
                <p class="text-2xl md:text-3xl font-inter font-black">
                    <span class="text-accent-black_2">OUR </span>
                    <span class="text-accent-orange-300">PROJECTS</span>
                </p>
                <p class="text-gray-800 text-sm font-medium text-center">FROM VISING TO REALITY - SEE WHAT WE'VE BUILT!
                </p>
            </div>


            <section class="p-4">
                {{-- filter tools --}}
                <section class="flex flex-col sm:flex-row items-end justify-end gap-2">

                    <div class="grow w-full md:max-w-[18rem]">
                        <x-public.searchbar
                        placeholder="Search projects..." 
                        x-model="filters.search"
                        @input.debounce.300ms="applyFilters"
                        id="searchbox_projects" />
                    </div>

                    <div class="w-[50%] sm:w-[35%] md:max-w-[12rem]">
                        <x-public.dropdown
                        name="filter_status" 
                        id="dropdown_filter_status"
                        label="Project Status" 
                        title="Select Project Status"
                        x-model="filters.status"
                        @change="applyFilters">
                            <option value="all">All</option>
                            <option value="on_going" class="text-accent-orange-300 p-1">Ongoing</option>
                            <option value="completed" class="text-accent-lightseagreen-50 p-1">Completed</option>
                        </x-public.dropdown>
                    </div>

                </section>

                {{-- Data --}}
                @php
                    // TODO: Make these server sided data retrieval.
                    $fake_data = [
                        [
                            'status' => 'ongoing',
                            'thumbnail' => asset('images/reftec_logo_transparent_16x9.png'),
                            'title' => 'Bacolor, Pampanga',
                            'description' => 'Hello World Thessssssss.',
                            'date' => '2023-10-01',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 2',
                            'description' => 'Description 2',
                            'date' => '2022-08-15',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 3',
                            'description' => 'Description 3',
                            'date' => '2021-05-20',
                        ],
                        [
                            'status' => 'ongoing',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 4',
                            'description' => 'Description 4',
                            'date' => '2023-11-11',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 5',
                            'description' => 'Description 5',
                            'date' => '2020-12-30',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 6',
                            'description' => 'Description 6',
                            'date' => '2019-07-04',
                        ],
                        [
                            'status' => 'ongoing',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 4',
                            'description' => 'Description 4',
                            'date' => '2023-11-11',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 5',
                            'description' => 'Description 5',
                            'date' => '2020-12-30',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 6',
                            'description' => 'Description 6',
                            'date' => '2019-07-04',
                        ],
                        [
                            'status' => 'ongoing',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 4',
                            'description' => 'Description 4',
                            'date' => '2023-11-11',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 5',
                            'description' => 'Description 5',
                            'date' => '2020-12-30',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 6',
                            'description' => 'Description 6',
                            'date' => '2019-07-04',
                        ],
                        [
                            'status' => 'ongoing',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 4',
                            'description' => 'Description 4',
                            'date' => '2023-11-11',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 5',
                            'description' => 'Description 5',
                            'date' => '2020-12-30',
                        ],
                        [
                            'status' => 'completed',
                            'thumbnail' => asset('images/layout_light_16x9.png'),
                            'title' => 'Project 6',
                            'description' => 'Description 6',
                            'date' => '2019-07-04',
                        ],
                    ];
                    $fake_data2 = [];
                @endphp
                <section class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 items-stretch">
                    <template x-if="dataLoading">
                        {{-- Loading Skeletons --}}
                        <template x-for="n in 6" :key="n">
                            <div class="p-2 h-60 grow relative bg-gray-300 animate-pulse rounded shadow-xl"></div>
                        </template>
                    </template>
                    <template x-if="!dataLoading && projectsData">
                        <template x-for="(project, i) in projectsData.data" :key="i + '_' + project.id">
                            <div class="h-60 relative cursor-pointer bg-gray-200 shadow-card p-4 rounded hover:shadow-xl transition-shadow duration-300 ease-in-out"
                                x-data @click="
                                    $dispatch('openmodal', { 
                                        modalID: 'modal_projects_public', 
                                        modal_header_text: 'Project Details',
                                        special_data: { 
                                            project_data : project 
                                        }
                                    });">
                                {{-- Image --}}
                                <img x-bind:src="project.images[0]" alt="Project Thumbnail"
                                    class="w-[95%] h-[92%] absolute inset-0 m-auto rounded object-cover bg-gray-200">


                                {{-- animated info --}}
                                <section
                                    class="absolute top-0 left-0 w-full h-full opacity-0 hover:opacity-100 transition-opacity duration-300 ease-in-out z-10">

                                    <div class="w-full h-full relative bg-red-300/50">
                                        <div
                                            class="relative w-full h-full rounded-sm bg-brand-primary-950/75 text-white p-4 pb-6 flex flex-col items-center justify-end">
                                            <template x-if="project.status === 'on_going'">
                                                <p
                                                    class="bg-accent-orange-300 absolute top-2 right-2 font-medium uppercase text-black px-2 py-1 rounded-full text-xs mb-2">
                                                    Ongoing
                                                </p>
                                            </template>
                                            <template x-if="project.status === 'completed'">
                                                <p
                                                    class="bg-accent-lightseagreen-50 absolute top-2 right-2 font-medium uppercase text-white px-2 py-1 rounded-full text-xs mb-2">
                                                    Completed
                                                </p>
                                            </template>

                                            <section
                                                class="px-6 w-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                                <h2 class="text-lg font-black text-wrap text-center w-full"
                                                    x-text="project.title.length > 40 ? project.title.substring(0, 40) + '...' : project.title">
                                                </h2>
                                                <h3 class="text-accent-orange-300 text-md text-center w-full"
                                                    x-text="project.description.length > 50 ? project.description.substring(0, 50) + '...' : project.description">
                                                </h3>
                                            </section>
                                        </div>
                                    </div>

                                </section>
                            </div>
                        </template>
                    </template>

                </section>

                {{-- Pagination --}}
                <template x-if="projectsData && !dataLoading">
                    <div class="mt-4 flex flex-col-reverse md:flex-row items-center justify-between gap-2">
                        <section>
                            <p class="text-sm font-medium text-gray-700">
                                Showing
                                <span class="font-bold" x-text="projectsData.from"></span>
                                to
                                <span class="font-bold" x-text="projectsData.to"></span>
                                of
                                <span class="font-bold" x-text="projectsData.total"></span>
                                projects
                            </p>
                        </section>
                        <section class="flex items-center justify-center gap-1 flex-wrap">
                            <!-- Previous Button -->
                            <x-public.button 
                                onclick="backToTop()"
                                @click="applyFilters(projectsData.current_page - 1)"
                                x-bind:disabled="!projectsData.prev_page_url"
                                class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                                <span class="flex items-center justify-center gap-2">
                                    @svg('fluentui-caret-left-24', 'w-6 h-6')
                                    Previous
                                </span>
                            </x-public.button>

                            <!-- Page Numbers -->
                            <div class="flex justify-center items-center gap-2 flex-wrap">
                                <template x-for="(page, index) in paginationRange()" :key="page + '_' + index">
                                    <x-public.button onclick="backToTop()" @click="page !== '...' && applyFilters(page)"
                                        x-bind:class="page === projectsData.current_page ? 'bg-brand-primary-600 text-white' : 'bg-white border'"
                                        class="px-3 py-1 rounded border cursor-pointer" x-text="page">
                                    </x-public.button>
                                </template>
                            </div>

                            <!-- Next Button -->
                            <x-public.button 
                                onclick="backToTop()"
                                @click="applyFilters(projectsData.current_page + 1)"
                                x-bind:disabled="!projectsData.next_page_url"
                                class="cursor-pointer shadow-sm bg-white hover:bg-accent-darkslategray-200 transition-colors">
                                <span class="flex items-center justify-center gap-2">
                                    @svg('fluentui-caret-right-24', 'w-6 h-6')
                                    Next
                                </span>
                            </x-public.button>

                        </section>
                    </div>
                </template>
            </section>
        </section>
    </x-public.content_container>

    <x-public.modal.public_preview_project />

    <x-public.footer />
</body>

</html>