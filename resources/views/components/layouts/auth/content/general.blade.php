<section class="font-inter flex item-start justify-start flex-wrap flex-col md:flex-row pb-2">

    <div x-data="{ activeTab: 'hero' }" class="flex flex-col md:flex-row gap-6">
        {{-- Tabs links --}}
        <div class="md:min-w-[200px]">
            <div class="sticky top-14 md:px-8 md:py-6 md:border-r-2 border-gray-200/75">
                <ul
                    class="
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
        <div class="grow min-h-[300px] p-4">
            <div x-show="activeTab === 'hero'" x-transition>

                <h2 class="font-medium text-xl my-2">Hero Section Backdrop Image</h2>

                {{-- Hero section image preview --}}
                <div class="bg-gray-300 rounded max-w-150 overflow-hidden">
                    <img src="{{ asset('images/bulan.jpg') }}" class="w-full cursor-pointer" title="preview image"
                        x-data @click="
                        $dispatch('image_preview_event', {
                            previewInfo: @js(['image' => asset('images/bulan.jpg')])
                        })
                    " />
                </div>

                <x-layouts.file_upload_drag />
                {{-- <form method="POST" action="{{ route('update.content.section.hero') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-accent-lightseagreen-100 rounded cursor-pointer hover:bg-accent-lightseagreen-200">TEST</button>
                </form> --}}

            </div>

            <div x-show="activeTab === 'products'" x-transition>
                <h2 class="text-xl font-bold mb-2">Product Lines</h2>
                <p>Display your different product categories or featured products here.</p>
            </div>

            <div x-show="activeTab === 'history'" x-transition>
                <h2 class="text-xl font-bold mb-2">History</h2>
                <p>Tell your brand’s story, milestones, or achievements in this section.</p>
            </div>

            <div x-show="activeTab === 'about'" x-transition>
                <h2 class="text-xl font-bold mb-2">About Us</h2>
                <p>Introduce your team, mission, and company values here.</p>
            </div>
        </div>
    </div>


</section>
<x-public.modal.image_preview escKeyToClose clickOutsideToClose />
