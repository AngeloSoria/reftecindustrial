<!DOCTYPE html>
<html lang="en">
<x-head />

<body class="bg-white">
    <x-navbar_public />

    <x-public-content-container>
        <div class="flex flex-col items-center justify-center my-12">
            <p class="text-2xl md:text-3xl font-inter font-black">
                <span class="text-accent-black_2">OUR </span>
                <span class="text-accent-yellow">PROJECTS</span>
            </p>
            <p class="text-gray-800 text-sm font-medium text-center">FROM VISING TO REALITY - SEE WHAT WE'VE BUILT!</p>
        </div>


        <section class="border border-black p-4">
            {{-- filter tools --}}
            <section class="flex flex-col md:flex-row items-end justify-end gap-2">
                <div class="flex flex-wrap items-end gap-2 justify-end w-full md:w-fit">
                    <x-searchbox id="searchbox_projects" class="grow w-full md:w-64 rounded-sm" />
                    <x-dropdown name="show_item_count" id="dropdown_show_item_count" class="rounded-sm"
                        label="Show item count">
                        <option value="10" selected>10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </x-dropdown>
                    <x-dropdown name="filter_status" id="dropdown_filter_status" class="rounded-sm"
                        label="Project Status" title="Select Project Status">
                        <option>All</option>
                        <option value="ongoing" class="text-accent-yellow p-1">Ongoing</option>
                        <option value="completed" class="text-accent-green p-1">Completed</option>
                    </x-dropdown>

                    {{-- TODO: Fill the option with detected years from projects. --}}
                    <x-dropdown name="filter_date" size="6" id="dropdown_filter_year" class="rounded-sm"
                        label="Year" title="Select Year Completed">
                        <option value="all">All</option>
                        @for ($year = date('Y'); $year >= 2005; $year--)
                            <option value="{{ $year }}">
                                {{ $year }}
                            </option>
                        @endfor
                    </x-dropdown>
                </div>
                <x-button_primary id="btn_apply_filters" class="px-4 py-2 rounded-sm cursor-pointer font-medium"
                    title="Apply Filters">
                    Apply Filters
                </x-button_primary>
            </section>

            {{-- Data --}}
            @php
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
                ];
            @endphp
            <section class="mt-4 p-4 flex flex-wrap gap-2 justify-start items-start">
                @foreach ($fake_data as $project)
                    <div class="w-88 h-60 grow relative border cursor-pointer"
                        x-data
                        @click="
                            $dispatch('preview_project_info', {
                                modalId: 'modal_previewProject',
                                projectInfo: @js($project)
                            })
                        ">
                        {{-- Image --}}
                        <img src="{{ $project['thumbnail'] }}" alt="Project Thumbnail"
                            class="w-full h-full absolute top-0 left-0 object-cover bg-gray-200">

                        {{-- animated info --}}
                        <section
                            class="absolute top-0 left-0 w-full h-full opacity-0 hover:opacity-100 transition-opacity duration-300 ease-in-out z-10">

                            <div class="w-full h-full relative bg-red-300/50">
                                <div
                                    class="relative w-full h-full bg-brand-primary/75 text-white p-4 pb-6 flex flex-col items-center justify-end">
                                    @if ($project['status'] === 'ongoing')
                                        <p
                                            class="bg-accent-yellow absolute top-2 right-2 font-medium uppercase text-black px-2 py-1 rounded-full text-xs mb-2">
                                            Ongoing
                                        </p>
                                    @else
                                        <p
                                            class="bg-accent-green absolute top-2 right-2 font-medium uppercase text-white px-2 py-1 rounded-full text-xs mb-2">
                                            Completed
                                        </p>
                                    @endif

                                    <section
                                        class="w-[95%] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                        <h2 class="text-lg font-black text-wrap text-center w-full">
                                            {{ $project['title'] }}</h2>
                                        <h3 class="text-accent-yellow text-md text-center w-full">
                                            {{ $project['description'] }}</h3>
                                    </section>
                                    <p class="text-xxs font-medium absolute bottom-2 left-2">{{ $project['date'] }}</p>
                                </div>
                            </div>

                        </section>
                    </div>
                @endforeach
            </section>
        </section>

    </x-public-content-container>

    <x-modal_preview_project id="modal_previewProject" size="4xl" keyEscapeClose  />

    <x-footer_public />
    <x-btn_backtotop />
</body>

</html>
