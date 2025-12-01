<section class="font-inter flex item-start justify-start flex-wrap flex-col md:flex-row pb-2">
    @php
        $activeSection = 'hero';
        if(session('content') && !empty(session('content')['section'])) {
            $activeSection = session('content')['section'];
        }
    @endphp
    <div x-data="{ activeSection: '{{ $activeSection }}' }" class="w-full flex flex-col md:flex-row gap-6">
        {{-- Tabs links --}}
        <div class="md:min-w-[200px]">
            <div class="sticky top-14 md:px-8 md:py-6 md:border-r-2 border-gray-200/75">
                <ul class="
                    list-outside flex flex-wrap flex-row md:flex-col gap-3 justify-center sm:justify-start
                    [&>*]:hover:bg-accent-darkslategray-200/50 [&>*]:cursor-pointer [&>*]:px-3 [&>*]:py-1 [&>*]:text-sm
                    ">

                    <li :class="activeSection === 'hero' ? 'text-accent-orange-300 border-b-3 border-accent-orange-300  md:border-none md:list-disc' : ''"
                        @click="activeSection = 'hero'">
                        Hero Section
                    </li>
                    <li :class="activeSection === 'products' ? 'text-accent-orange-300 border-b-3 border-accent-orange-300  md:border-none md:list-disc' : ''"
                        @click="activeSection = 'products'">
                        Product Lines
                    </li>
                    <li :class="activeSection === 'history' ? 'text-accent-orange-300 border-b-3 border-accent-orange-300 md:border-none md:list-disc' : ''"
                        @click="activeSection = 'history'">
                        History
                    </li>
                    <li :class="activeSection === 'about' ? 'text-accent-orange-300 border-b-3 border-accent-orange-300 md:border-none md:list-disc' : ''"
                        @click="activeSection = 'about'">
                        About Us
                    </li>
                </ul>

            </div>
        </div>

        {{-- Preview / Tab Content --}}
        <div class="grow min-h-[300px] p-4 w-full">
            <div x-show="activeSection === 'hero'" x-transition>
                <x-auth.content.general.hero_section />
            </div>

            <div x-show="activeSection === 'products'" x-transition>
                <x-auth.content.general.product_lines />
            </div>

            <div x-show="activeSection === 'history'" x-transition>
                <x-auth.content.general.history />
            </div>

            <div x-show="activeSection === 'about'" x-transition>
                <x-auth.content.general.about_us />
            </div>
        </div>
    </div>


</section>
