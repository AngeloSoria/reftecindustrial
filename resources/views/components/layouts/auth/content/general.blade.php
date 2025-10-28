<section class="font-inter flex item-start justify-start flex-wrap flex-col md:flex-row pb-2">

    <div x-data="{ activeTab: '{{ session('content') ? session('content')['section'] : 'hero' }}' }" class="w-full flex flex-col md:flex-row gap-6">
        {{-- Tabs links --}}
        <div class="md:min-w-[200px]">
            <div class="sticky top-14 md:px-8 md:py-6 md:border-r-2 border-gray-200/75">
                <ul class="
                    list-outside flex flex-wrap flex-row md:flex-col gap-3 justify-center sm:justify-start
                    [&>*]:hover:bg-accent-darkslategray-200/50 [&>*]:cursor-pointer [&>*]:px-3 [&>*]:py-1 [&>*]:text-sm
                    ">

                    <li :class="activeTab === 'hero' ? 'text-accent-orange-300 border-b-3 border-accent-orange-300  md:border-none md:list-disc' : ''"
                        @click="activeTab = 'hero'">
                        Hero Section
                    </li>
                    <li :class="activeTab === 'products' ? 'text-accent-orange-300 border-b-3 border-accent-orange-300  md:border-none md:list-disc' : ''"
                        @click="activeTab = 'products'">
                        Product Lines
                    </li>
                    <li :class="activeTab === 'history' ? 'text-accent-orange-300 border-b-3 border-accent-orange-300 md:border-none md:list-disc' : ''"
                        @click="activeTab = 'history'">
                        History
                    </li>
                    <li :class="activeTab === 'about' ? 'text-accent-orange-300 border-b-3 border-accent-orange-300 md:border-none md:list-disc' : ''"
                        @click="activeTab = 'about'">
                        About Us
                    </li>
                </ul>

            </div>
        </div>

        {{-- Preview / Tab Content --}}
        <div class="grow min-h-[300px] p-4 w-full">
            <div x-show="activeTab === 'hero'" x-transition>
                <x-auth.content.general.hero_section />
            </div>

            <div x-show="activeTab === 'products'" x-transition>
                <x-auth.content.general.product_lines />
            </div>

            <div x-show="activeTab === 'history'" x-transition>
                <x-auth.content.general.history />
            </div>

            <div x-show="activeTab === 'about'" x-transition>
                <x-auth.content.general.about_us />
            </div>
        </div>
    </div>


</section>
<x-public.modal.image_preview escKeyToClose clickOutsideToClose />
