<!DOCTYPE html>
<html lang="en">
<x-partials.head />

<body>
    <x-public.navbar />

    <div class="flex flex-col items-center justify-center my-12">
        <p class="text-2xl md:text-3xl font-inter font-black">
            <span class="text-accent-black_2">GET TO </span>
            <span class="text-accent-orange-300">KNOW US</span>
        </p>
        <p class="text-gray-800 text-sm font-medium text-center">PASSION FOR INNOVATION, COMMITMENT TO EXCELLENCE - THIS
            IS WHO WE ARE!</p>
    </div>

    {{-- Collage --}}
    {{-- TODO: Make this server-sided. --}}
    <section class="relative h-[200px]">
        <div class="grid grid-cols-3 h-full">
            @php
                $fake_data = [
                    asset('images/layout_light_16x9.png'),
                    asset('images/layout_light_16x9.png'),
                    asset('images/layout_light_16x9.png'),
                ];
            @endphp
            @for($index = 0; $index < 3; $index++)
                <div class="bg-cover bg-no-repeat bg-center" style="background-image: url({{ $fake_data[$index] }});"></div>
            @endfor
        </div>

        {{-- gradient fade --}}
        <div class="bg-linear-to-b from-black/5 to-black/75 absolute bottom-0 left-0 w-full h-[40%]"></div>
    </section>

    {{-- Detailed Info --}}
    <x-public.content_container minHeight="min-h-[10vh]">

        <section class="mx-auto w-[90%] md:w-[75%] lg:w-[55%]">
            {{-- small box --}}
            <div data-aos="fade-right" data-aos-anchor-placement="center-center">
                <div
                    class="bg-transparent border-3 border-accent-orange-300 w-[200px] h-[70px] transform -translate-x-15 translate-y-7">
                </div>
            </div>
            {{-- bigger box --}}
            <div data-aos="fade-left" data-aos-anchor-placement="top-center">
                <div class="bg-transparent border-3 border-accent-orange-300 px-8 py-14 ">
                    {{-- TODO: Make the text here server-sided. --}}
                    <p class="font-inter text-xl font-medium">
                        Founded in 2005 as a sole proprietorship, <span class="font-black text-brand-secondary-300">REFTEC
                            Industrial
                            Supply and Services Inc.</span> is a 100%
                        Filipino-owned company. In 2011, it was officially registered as a corporation with the
                        Securities
                        and Exchange Commission.
                        <br />
                        <br />
                        REFTEC specializes in the installation of ice plants and cold storage
                        facilities, as well as the fabrication of ice plant components. The company also supplies and
                        installs commercial water tanks, engages in the water systems business, and offers a range of
                        services related to the water and refrigeration industries.
                    </p>
                </div>
            </div>
        </section>

    </x-public.content_container>

    {{-- Mission and Vision --}}
    <secti55 class="mt-10 grid grid-cols-1 gap-1 md:gap-0 md:grid-cols-2 overflow-hidden">
        <div data-aos="fade-right" data-aos-anchor-placement="top-center"
            style="background-image: url({{ asset('images/bulan.jpg') }});"
            class="relative bg-center bg-cover p-16 py-16 flex flex-col items-center justify-center text-center">
            <h2 class="font-black text-2xl text-accent-orange-300 z-2">MISSION</h2>
            <p class="text-white z-2">To provide the finest quality in all our products and services for the benefit of
                customers, shareholders, employees and community.</p>
            <div class="absolute inset-0 w-full h-full bg-accent-darkslategray-800/75"></div>
        </div>
        <div data-aos="fade-left" data-aos-anchor-placement="top-center"
            style="background-image: url({{ asset('images/footerbg.jpg') }});"
            class="relative bg-center bg-cover p-16 py-16 flex flex-col items-center justify-center text-center">
            <h2 class="font-black text-2xl text-accent-orange-300 z-2">VISION</h2>
            <p class="text-white z-2">To be the company that best understands customers' needs.</p>
            <div class="absolute inset-0 w-full h-full bg-accent-darkslategray-800/75"></div>
        </div>
    </secti55>

    <x-public.footer />
</body>

</html>
