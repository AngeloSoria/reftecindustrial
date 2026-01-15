<!DOCTYPE html>
<html lang="en">
<x-partials.head />

<body x-data="homeContentHandler" class="bg-white">
    <x-public.navbar />

    {{-- Hero section --}}
    <section class="w-full h-100 bg-cover bg-center flex items-center justify-start relative" x-ref="ref_heroBackdrop">
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
        <section class="px-4 my-12 relative">
            <div class="flex flex-col items-center justify-center">
                <p class="text-2xl md:text-3xl font-inter font-black text-accent-orange-300">PRODUCT LINES</p>
                <p class="text-black text-sm font-medium text-center">HERE TO PROVIDE YOU TOP NOTCH SERVICES AND
                    PRODUCTS</p>
            </div>


            <section x-data class="mt-8">
                <section class="fade-edges-horizontal overflow-hidden">
                    <template x-if="productLinesData">
                        <div class="flex items-center"
                            :class="Object.keys(productLinesData.data).length > 2 ? 'animate-logo-conveyor' : 'justify-center'">
                            <template
                                x-for="i in Array.from({ length: Object.keys(productLinesData.data).length > 2 ? 2 : 1 }, (_, index) => index)">
                                <template x-for="productLine in productLinesData.data">
                                    <div class="grow p-4 flex flex-col items-center justify-center">
                                        <img :src="productLine.image_path" :title="productLine.name"
                                            class="max-w-30 sm:max-w-40 md:max-w-80 max-h-24 object-contain bg-white transition-all duration-300" />
                                    </div>
                                </template>
                            </template>
                        </div>
                    </template>
                </section>
            </section>

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
                    <p x-ref="ref_HistoryText"
                        class="text-sm md:text-base text-justify font-inter font-medium leading-relaxed">
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
                <div data-aos="fade-left" data-aos-anchor-placement="top-bottom" data-aos-duration="1000"
                    class="order-1 md:order-2 w-full md:h-auto aspect-video md:aspect-auto overflow-hidden">
                    <img x-ref="ref_HistoryImage" src="{{ asset('images/our_history.png') }}" alt="Our History"
                        class="w-full h-full object-cover" />
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
                <template x-if="highlightedProjectsData">
                    <template x-for="(project, index) in highlightedProjectsData.data" :key="index">
                        <div
                            class="bg-gray-100 shadow-lg md:shadow-none md:bg-transparent flex flex-col md:flex-row items-end justify-center">
                            <!-- IMAGE LEFT (even index) -->
                            <template x-if="index % 2 === 0">
                                <div class="flex w-full items-end md:flex-row flex-col">
                                    <div data-aos="fade-right" data-aos-duration="900"
                                        class="w-full h-full lg:w-[685px] lg:h-[400px] overflow-hidden rounded-xl shadow-xl">
                                        <img :src="project.images[0]" :alt="project.title"
                                            class="w-full h-full object-fill" />
                                    </div>

                                    <div data-aos="fade-left" data-aos-duration="900"
                                        class="z-2 w-full mt-2 lg:w-1/2 mb-6 flex flex-col justify-center">
                                        <div>
                                            <span class="text-sm text-white px-2 py-1 font-medium uppercase"
                                                :class="project.status == 'completed' ? 'bg-green-400' : project.status ==
                                                    'on_going' ? 'bg-yellow-500' : 'bg-red-500'"
                                                x-text="project.status"></span>
                                        </div>

                                        <div class="p-4 md:bg-brand-primary-950 text-black md:text-white">
                                            <h2 class="text-xl font-bold" x-text="project.title"></h2>
                                            <p class="text-sm" x-text="project.description"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- IMAGE RIGHT (odd index) -->
                            <template x-if="index % 2 === 1">
                                <div class="flex w-full items-end md:flex-row flex-col">
                                    <div data-aos="fade-right" data-aos-duration="900"
                                        class="z-2 w-full lg:w-1/2 mb-6 flex flex-col justify-center">
                                        <div>
                                            <span class="text-sm text-white px-2 py-1 font-medium uppercase"
                                                :class="project.status == 'completed' ? 'bg-green-400' : project.status ==
                                                    'on_going' ? 'bg-yellow-500' : 'bg-red-500'"
                                                x-text="project.status"></span>
                                        </div>

                                        <div class="p-4 md:bg-brand-primary-950 text-black md:text-white">
                                            <h2 class="text-xl font-bold" x-text="project.title"></h2>
                                            <p class="text-sm" x-text="project.description"></p>
                                        </div>
                                    </div>

                                    <div data-aos="fade-left" data-aos-duration="900"
                                        class="w-full lg:w-[685px] lg:h-[400px] overflow-hidden rounded-xl shadow-xl">
                                        <img :src="project.images[0]" :alt="project.title"
                                            class="w-full h-full object-fill" />
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </template>
            </section>


            <div data-aos="fade-up" class="w-full flex justify-center items-center p-8 mt-8">
                <x-public.button button_type="primary" href="{{ route('projects') }}"
                    class="rounded font-bold text-white" size="2xl">
                    View All Projects
                </x-public.button>
            </div>
        </section>
    </x-public.content_container>

    <x-public.footer />
    <script>
        function homeContentHandler() {
            return {
                homeDataLoaded: false,
                heroData: null,
                productLinesData: null,
                historyData: null,
                highlightedProjectsData: null,

                async init() {
                    const response = await fetch('{{ route('api.content.page.home') }}', {
                        credentials: 'omit'
                    });
                    const data = await response.json();

                    // home
                    if (data.hero && data.hero.original) {
                        this.heroData = data.hero.original;
                        if (this.heroData.success) {
                            this.setHeroBG(this.heroData.data.image);
                        } else {
                            return console.error('Failed to load hero image.');
                        }
                    }

                    // product lines
                    if (data.product_lines && data.product_lines.original) {
                        this.productLinesData = data.product_lines.original;
                        if (!this.productLinesData.success) {
                            return console.error('Failed to load product lines.');
                        }
                    }

                    // history (description & image)
                    if (data.history && data.history.original) {
                        this.historyData = data.history.original;
                        if (!this.historyData.success) {
                            return console.error('Failed to load history.');
                        } else {
                            // set Image
                            this.$refs.ref_HistoryImage.src = this.historyData.data.image;

                            // set Description
                            this.$refs.ref_HistoryText.innerHTML = this.historyData.data.description;
                        }
                    }

                    // highlighted projects
                    if (data.projects && data.projects.original) {
                        this.highlightedProjectsData = data.projects.original;
                        if (!this.highlightedProjectsData.success) {
                            return console.error('Failed to load highlighted projects.');
                        }
                    }


                    this.homeDataLoaded = true;
                },

                setHeroBG(image_path = @js(asset('images/JSP-building-landscape.png'))) {
                    const img = new Image();
                    img.src = image_path;

                    // Wait until the actual image is fully loaded
                    img.onload = () => {
                        this.$refs.ref_heroBackdrop.style.backgroundImage = `url(${image_path})`;
                    };
                },
            };
        }
    </script>
</body>

</html>
