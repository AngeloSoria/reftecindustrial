@php

$nav_links = [
    ['name' => 'Home', 'route' => 'home'],
    ['name' => 'Projects', 'route' => 'projects'],
    ['name' => 'Products', 'route' => 'products'],
    ['name' => 'About Us', 'route' => 'about_us'],
];

@endphp

<nav class="shadow-md bg-white px-5 py-2 top-0 z-50 transition-all duration-300 ease-out transform scale-y-100 origin-top" id="main-navbar">
    <section class="max-w-6xl mx-auto">
        {{-- main nav --}}
        <section class="flex flex-wrap justify-between items-center mx-auto">
            {{-- Left --}}
            <a href="{{ false ? null : route('home') }}" class="flex items-center space-x-2 py-2">
                <img src="{{ asset('images/reftec_logo_notext.svg') }}" class="w-15 sm:w-20" alt="Logo" loading="lazy">
                <span class="p-0 m-0 font-semibold text-xs md:text-lg text-gray-800 font-castle uppercase">Industrial Supply and <br class="block sm:hidden"/> Services Inc.</span>
            </a>

            {{-- Mobile Menu button --}}
            <section class="md:hidden">
                <button id="mobile-menu-toggle" class="p-2 rounded hover:bg-gray-200 cursor-pointer">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </section>

            {{-- Right --}}
            <section class="hidden md:block">
                <ul class="flex space-x-2">
                    @foreach ($nav_links as $link)
                        @if (Route::has($link['route']))
                            <li class="px-2 py-2">
                                <a href="{{ route($link['route']) }}" class="{{ ($currentRouteName ?? '') === $link['route'] ? 'font-bold text-accent-yellow' : 'text-black  font-regular' }} text-sm uppercase hover:font-bold">{{ $link['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </section>
        </section>

        {{-- mobile nav --}}
        <section class="flex justify-center">
            {{-- Mobile Menu button --}}
            <section id="mobile-menu" class="flex-1 md:hidden hidden transition-all duration-300 ease-out transform -translate-y-4 opacity-0 pointer-events-none">
                <ul class="w-full flex flex-col">
                    @foreach ($nav_links as $link)
                        @if (Route::has($link['route']))
                            <li class="w-full px-4 py-2 text-center font-inter">
                                <a href="{{ route($link['route']) }}" class="{{ ($currentRouteName ?? '') === $link['route'] ? 'font-bold text-accent-yellow' : 'text-black  font-regular' }} text-sm uppercase hover:font-bold">{{ $link['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </section>
        </section>
    </section>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        toggleBtn.addEventListener('click', function () {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.remove('-translate-y-4', 'opacity-0', 'pointer-events-none');
                    mobileMenu.classList.add('translate-y-0', 'opacity-100');
                }, 10);
            } else {
                mobileMenu.classList.remove('translate-y-0', 'opacity-100');
                mobileMenu.classList.add('-translate-y-4', 'opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300); // match duration-300
            }
        });
    });
</script>
