<!DOCTYPE html>
<html lang="en">
<x-partials.head />

<body class="bg-white">
    <x-public.navbar />

    {{-- Hero section --}}
    {{-- TODO: Server rendered background-image of hero section. --}}
    <section class="w-full h-100 bg-cover bg-center flex items-center justify-start relative"
        style="background-image: url('{{ asset('images/bulan.jpg') }}');" x-ref="heroBackdrop" x-data="{async init() {
                try {
                    const response = await fetch('{{ route('content.get.section.hero') }}');
                    const data = await response.json();

                    const img = new Image();
                    img.src = '/storage/' + data.image_path;
                    // Wait until the actual image is fully loaded
                    img.onload = () => {
                        this.$refs.heroBackdrop.style.backgroundImage = 'url(' + img.src + ')';
                    };
                } catch (e) {
                    console.error('Failed to load hero image:', e);
                }
            }
        }">
        <div class="block absolute top-0 left-0 w-full h-full bg-black/85 z-0"></div>
        <section class="max-w-6xl z-1 mx-auto flex items-center justify-center sm:justify-start w-full px-2 md:px-6">
            <div
                class="font-inter p-2 flex flex-col items-center sm:items-start justify-center sm:justify-start space-y-2 w-full">
                {{-- get the current year and minus it from 2005 --}}
                <h1 class="text-1xl md:text-2xl text-white italic font-regular">Celebrating {{ date('Y') - 2005 }} years
                    of</h1>
                <h1
                    class="text-2xl md:text-4xl text-white uppercase font-black text-wrap max-w-2xl text-center sm:text-start">
                    Reliable Refrigeration & Water System Engineering</h1>
                <div class="mt-4 flex space-x-4">
                    <x-public.button button_type="primary" href="#footer_">Contact Us</x-public.button>
                    <x-public.button button_type="secondary" href="#OurHistory_">Learn More</x-public.button>
                </div>
            </div>
        </section>
    </section>

    <x-public.content_container>
        {{-- Product Lines --}}
        <section class="px-4 my-6 relative">
            <div class="flex flex-col items-center justify-center">
                <p class="text-2xl md:text-3xl font-inter font-black text-accent-orange-300">PRODUCT LINES</p>
                <p class="text-black text-sm font-medium text-center">HERE TO PROVIDE YOU TOP NOTCH SERVICES AND
                    PRODUCTS</p>
            </div>

            {{-- TODO: Server rendered product lines. --}}
            <div data-aos="fade-up" data-aos-anchor-placement="center-center"
                class="mt-4 bg-accent-darkslategray-900 grid gap-1 md:gap-0 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 relative">
                @php
                    // TODO: This will be replaced by server rendered product lines.
                    $productLines = [
                        [
                            'name' => 'KINGSPAN RHINO WATER TANKS, AUSTRALIA',
                            'image' => asset('images/kingspan.jpg'),
                        ],
                        [
                            'name' => 'STARR PANEL, INDONESIA',
                            'image' => asset('images/starr.jpg'),
                        ],
                        [
                            'name' => 'VILTER REFRIGERATION EQUIPMENT, USA',
                            'image' => asset('images/vilter_logo.png'),
                        ],
                    ];
                @endphp
                @foreach ($productLines as $productLine)
                    <section class="w-full relative h-24 overflow-hidden">
                        {{-- Image --}}
                        <img src="{{ $productLine['image'] }}" alt="{{ $productLine['name'] }}" class="w-full m-auto" />

                        {{-- Product Name --}}
                        <div class="z-2 w-[90%] absolute bottom-0 left-1/2 -translate-x-1/2 p-2 text-white text-center">
                            <h2 class="text-sm text-shadow font-medium">{{ $productLine['name'] }}</h2>
                        </div>

                        {{-- Bottom Vignette --}}
                        <div
                            class="z-1 absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-black/90 to-transparent pointer-events-none">
                        </div>
                    </section>
                @endforeach
            </div>
        </section>

        {{-- Our History --}}
        <section id="OurHistory_" class="scroll-mt-16 px-4 my-6 mt-[100px] relative overflow-hidden">
            <div data-aos="fade-right" data-aos-duration="1500"
                class="flex flex-col mb-10 items-center md:items-start md:ms-[80px]">
                <p class="text-2xl md:text-3xl font-inter font-black">
                    <span class="text-accent-black_2">OUR</span>
                    <span class="text-accent-orange-300">HISTORY</span>
                </p>
            </div>

            <div class="mt-4 p-4 md:p-6 grid grid-cols-1 md:grid-cols-2 gap-2">

                {{-- Text --}}
                <div data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="1200"
                    class="text-black order-2 md:order-1 bg-[#ecf0f1] shadow-md flex flex-col justify-center item-end -border-4 -border-accent-orange-300 p-6 rounded">
                    <p x-ref="data_history" x-data="{
                        async init() {
                            const response = await fetch('{{ route('content.get.section.history') }}');
                            const data = await response.json();

                            if(data) {
                                this.$refs.data_history.innerHTML = data.content;
                            }
                        },
                    }"
                    class="text-sm md:text-base text-justify font-inter font-medium leading-relaxed">
                        {{-- placeholder before the updated data from the database. --}}
                        Founded in 2005 as Single Proprietorship,<span class="font-black text-brand-secondary-300">
                            REFTEC
                            Industrial Supply and Services Inc.</span> is 100%
                        Filipino-owned Company and was registered with Securities and Exchange Commission as Corporation
                        in 2011.

                        <br />
                        <br />

                        The main business is installing ice plants and cold storages and fabricating ice plant
                        components. It also supplies and installs commercial water tanks and other services related to
                        water industry and refrigeration.
                    </p>
                    <section class="flex justify-end w-full">
                        <x-public.button button_type="secondary" href="{{ route('aboutus') }}"
                            class="mt-4 rounded flex items-center gap-2">
                            Learn More
                            @svg('fluentui-arrow-right-16-o', 'w-4 h-4 text-white')
                        </x-public.button>
                    </section>
                </div>

                {{-- Image --}}
                {{-- TODO: Use server sided image here. --}}
                <div data-aos="fade-left" data-aos-anchor-placement="top-bottom" data-aos-duration="1000"
                    class="order-1 md:order-2 w-full md:h-auto aspect-video md:aspect-auto overflow-hidden">
                    <img src="{{ asset('images/our_history.png') }}" alt="Our History"
                        class="w-full h-full object-cover" loading="lazy" />
                </div>

            </div>
        </section>

        {{-- Highlighted Projects --}}
        <section class="scroll-mt-16 px-4 my-6 mt-[100px] relative">
            <div data-aos="fade-down" data-aos-duration="1200" class="flex flex-col items-center">
                <p class="text-2xl md:text-3xl font-inter font-black">
                    <span class="text-accent-black_2">AND</span>
                    <span class="text-accent-orange-300">PROJECTS</span>
                </p>
            </div>

            {{-- TODO: Must be a server-sided rendering of Highlighted Projects here. --}}
            <section class="flex flex-col space-y-7 lg:space-y-20 mt-20 overflow-hidden">
                @php
                    // Example highlighted projects array
                    $highlightedProjects = [
                        [
                            'title' => 'Project Title 1',
                            'description' => 'Brief description of Project 1. This is a placeholder text.',
                            'image' => asset('images/layout_light_16x9.png'),
                            'status' => 'COMPLETED',
                            'status_color' => 'bg-accent-lightseagreen-50',
                        ],
                        [
                            'title' => 'Project Title 2',
                            'description' => 'Brief description of Project 2. This is a placeholder text.',
                            'image' => asset('images/layout_light_16x9.png'),
                            'status' => 'COMPLETED',
                            'status_color' => 'bg-accent-lightseagreen-50',
                        ],
                        [
                            'title' => 'Project Title 3',
                            'description' => 'Brief description of Project 3. This is a placeholder text.',
                            'image' => asset('images/layout_light_16x9.png'),
                            'status' => 'ON GOING',
                            'status_color' => 'bg-accent-orange-300',
                        ],
                    ];
                @endphp

                @for ($i = 0; $i < count($highlightedProjects); $i++)
                    @php
                        $project = $highlightedProjects[$i];
                        $isEven = $i % 2 === 1;
                    @endphp
                    <div
                        class="p-4 bg-gray-100 shadow-lg md:shadow-none md:bg-transparent flex flex-col md:flex-row items-end justify-center lg:space-x-[-150px] md:-space-x-28">
                        @if (!$isEven)
                            {{-- Image Left --}}
                            <div data-aos="fade-right" data-aos-duration="900"
                                class="w-full h-full lg:w-[685px] lg:h-[400px] overflow-hidden">
                                <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}"
                                    class="w-full h-full object-fill" loading="lazy" />
                            </div>
                            {{-- Context Right --}}
                            <div data-aos="fade-left" data-aos-duration="900"
                                class="z-2 w-full mt-2 lg:w-1/2 mb-6 flex flex-col justify-center">
                                <div>
                                    <span
                                        class="text-sm text-white {{ $project['status_color'] }} px-2 py-1 font-medium">{{ $project['status'] }}</span>
                                </div>
                                <div class="p-4 md:bg-brand-primary-950 text-black md:text-white">
                                    <h2 class="text-xl font-bold">{{ $project['title'] }}</h2>
                                    <p class="text-sm">{{ $project['description'] }}</p>
                                </div>
                            </div>
                        @else
                            {{-- Context Left --}}
                            <div data-aos="fade-right" data-aos-duration="900"
                                class="z-2 w-full lg:w-1/2 mb-6 flex flex-col justify-center">
                                <div>
                                    <span
                                        class="text-sm text-white {{ $project['status_color'] }} px-2 py-1 font-medium">{{ $project['status'] }}</span>
                                </div>
                                <div class="p-4 md:bg-brand-primary-950 text-black md:text-white">
                                    <h2 class="text-xl font-bold">{{ $project['title'] }}</h2>
                                    <p class="text-sm">{{ $project['description'] }}</p>
                                </div>
                            </div>
                            {{-- Image Right --}}
                            <div data-aos="fade-left" data-aos-duration="900"
                                class="w-full lg:w-[685px] lg:h-[400px] overflow-hidden">
                                <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}"
                                    class="w-full h-full object-fill" loading="lazy" />
                            </div>
                        @endif
                    </div>
                @endfor
            </section>

            <div data-aos="fade-up" class="w-full flex justify-center items-center p-8">
                <x-public.button button_type="primary" href="{{ route('projects') }}"
                    class="rounded font-bold text-white" size="2xl">
                    View All Projects
                </x-public.button>
            </div>
        </section>
    </x-public.content_container>

    <x-public.footer />
</body>

</html>
