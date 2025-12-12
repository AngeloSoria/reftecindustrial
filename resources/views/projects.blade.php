<!DOCTYPE html>
<html lang="en">
<x-partials.head />

<body class="bg-white">
    <x-public.navbar />

    <x-public.content_container>
        <section x-data="{
                projectsData: null,
                isDataLoading: true,
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
                            this.isDataLoading = false;
                            console.log(this.projectsData);
                        } else {
                            console.error('Failed to load projects data:', result.message);
                        }
                    } catch (error) {
                        console.error('Error fetching projects data:', error);
                    }
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
                <section class="flex flex-col md:flex-row items-end justify-end gap-2">

                    <x-public.searchbar id="searchbox_projects" class="grow w-full md:max-w-[18rem]" />

                    <x-public.dropdown name="filter_status" id="dropdown_filter_status"
                        class="grow max-w-full md:max-w-[12rem]" label="Project Status" title="Select Project Status">
                        <option>All</option>
                        <option value="ongoing" class="text-accent-orange-300 p-1">Ongoing</option>
                        <option value="completed" class="text-accent-lightseagreen-50 p-1">Completed</option>
                    </x-public.dropdown>


                    {{-- TODO: Fill the option with detected years from projects. --}}
                    {{-- <x-public.dropdown name="filter_date" size="6" id="dropdown_filter_year"
                        class="grow md:max-w-[12rem] w-full md:w-fit" label="Year" title="Select Year Completed">
                        <option value="all">All</option>
                        @for ($year = date('Y'); $year >= 2005; $year--)
                        <option value="{{ $year }}">
                            {{ $year }}
                        </option>
                        @endfor
                    </x-public.dropdown> --}}


                    {{-- <x-public.button button_type="primary" id="btn_apply_filters"
                        class="px-4 py-2 rounded-sm cursor-pointer font-medium w-full max-w-[10rem] md:w-fit"
                        title="Apply Filters">
                        Apply Filters
                    </x-public.button> --}}
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
                <section class="mt-4 grid grid-cols-2 lg:grid-cols-3 gap-2 items-stretch">
                    <template x-if="isDataLoading">
                            {{-- Loading Skeletons --}}
                            <template x-for="n in 6" :key="n">
                                <div class="p-2 h-60 grow relative bg-gray-300 animate-pulse rounded shadow-xl"></div>
                            </template>
                    </template>
                    <template x-if="!isDataLoading && projectsData">
                        <template x-for="(project, i) in projectsData.data" :key="i + '_' + project.id">
                            <div class="h-60 relative cursor-pointer bg-white shadow-card p-4 rounded"
                                x-data
                                @click="$dispatch('preview_project_info', { modalId: 'modal_previewProject', projectInfo: project });">
                                {{-- Image --}}
                                <img x-bind:src="project.images[0]" alt="Project Thumbnail"
                                    class="w-[95%] h-[92%] absolute inset-0 m-auto object-cover bg-gray-200">


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
                                                <h2 class="text-lg font-black text-wrap text-center w-full" x-text="project.title.length > 40 ? project.title.substring(0, 40) + '...' : project.title"></h2>
                                                <h3 class="text-accent-orange-300 text-md text-center w-full" x-text="project.description.length > 50 ? project.description.substring(0, 50) + '...' : project.description"></h3>
                                            </section>
                                        </div>
                                    </div>

                                </section>
                            </div>
                        </template>
                    </template>

                </section>
                {{-- Pagination --}}
                <div class="w-full mt-4 flex items-start justify-end gap-2">
                    <section class="flex items-center justify-center gap-2 flex-wrap">
                        <!-- Previous Button -->
                        <x-public.button
                            class="cursor-pointer shadow-card bg-white hover:bg-accent-darkslategray-200 transition-colors">
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
                        <x-public.button
                            class="cursor-pointer shadow-card bg-white hover:bg-accent-darkslategray-200 transition-colors">
                            <span class="flex items-center justify-center gap-2">
                                @svg('fluentui-caret-right-24', 'w-6 h-6')
                                Next
                            </span>
                        </x-public.button>

                    </section>
                </div>
            </section>
        </section>
    </x-public.content_container>

    <x-public.modal.preview_project id="modal_previewProject" size="3xl" keyEscapeClose clickOutsideToClose />

    <x-public.footer />
</body>

</html>