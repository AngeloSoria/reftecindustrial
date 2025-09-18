<?php
// Retrieve hero image from server path, but load the static image for now.
$defaultHeroImage = 'images/bulan.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<x-head />

<body class="bg-gray-200">
    <x-navbar_public currentRouteName="home" />

    {{-- Hero section --}}
    {{-- TODO: Server rendered background-image of hero section. --}}
    <section class="w-full h-100 bg-cover bg-center flex items-center justify-start relative"
        style="background-image: url('{{ asset($defaultHeroImage) }}');">
        <div class="block absolute top-0 left-0 w-full h-full bg-black/85 z-0"></div>
        <section class="max-w-6xl z-1 mx-auto flex items-center justify-center sm:justify-start w-full px-2 md:px-6">
            <div
                class="font-inter p-2 flex flex-col items-center sm:items-start justify-center sm:justify-start space-y-2 w-full">
                {{-- get the current year and minus it from 2005 --}}
                <h1 class="text-2xl md:text-2xl text-white italic font-regular">Celebrating {{ date('Y') - 2005 }} years
                    of</h1>
                <h1
                    class="text-3xl md:text-4xl text-white uppercase font-black text-wrap max-w-2xl text-center sm:text-start">
                    Reliable Refrigeration & Water System Engineering</h1>
                <div class="mt-4 flex space-x-4">
                    <x-button button_type="primary" href="#footer_">Contact Us</x-button>
                    <x-button button_type="secondary">Learn More</x-button>
                </div>
            </div>
        </section>
    </section>

    <x-public-content-container>
        {{-- Product Lines --}}
        <section class="px-4 my-6">
            <div class="flex flex-col items-center">
                <p class="text-3xl font-inter font-black text-accent-yellow">PRODUCT LINES</p>
                <p class="text-sm font-medium">HERE TO PROVIDE YOU TOP NOTCH SERVICES AND PRODUCTS</p>
            </div>

            {{-- TODO: Server rendered product lines. --}}
            <div class="mt-4 bg-accent-black_2 flex">
                {{-- TODO: Use ForEach here --}}
                {{-- FIXME: Undesired layout for product lines. --}}
                @for ($i = 0; $i < 3; $i++)
                    <div class="flex-1 flex-col border border-white relative">
                        <div class=""></div>
                            <img src="{{ asset('images/kingspan.jpg') }}" alt="Airconditioning"
                                class="w-full h-24 object-fit" />
                        </div>
                        <div class="p-4 text-white text-center bg-red-300">
                            <h2 class="text-xl font-bold mb-2">Airconditioning Systems</h2>
                        </div>
                    </div>
                @endfor
        </section>
    </x-public-content-container>


    <x-footer_public />

    <x-btn_backtotop />
</body>

</html>
