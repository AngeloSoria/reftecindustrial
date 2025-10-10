<section class="bg-brand-primary-950 text-white w-full min-h-[52px] font-inter px-2 md:px-4 py-1
    hidden md:grid grid-cols-2 md:grid-cols-3 gap-y-1 md:gap-y-0 overflow-hidden">
    <div class="flex gap-2 items-center justify-center sm:justify-start">
        @svg("fluentui-location-12", "w-4 h-4")
        <h2 class="text-xs md:text-sm">Brgy. Ugong, Valenzuela City, Philippines</h2>
    </div>
    <div class="flex gap-2 flex-row items-center justify-center sm:justify-end md:justify-center">
        @svg("fluentui-call-12", "w-4 h-4 md:hidden")
        <p class="text-sm hidden md:block">Call Us:</p>
        <a href="tel:+63287063393" class="hover:underline">
            <h2 class="text-xs md:text-xl font-medium">+63 2 8706 3393</h2>
        </a>
    </div>
    <div
        class="flex gap-1 col-span-2 md:col-span-1 flex-col sm:flex-row md:flex-col items-center sm:items-end justify-between md:justify-center">
        <div class="flex gap-2 items-end justify-center">
            @svg("fluentui-mail-16", "w-4 h-4")
            <a href="mailto:reftecindustrialsupply@gmail.com" class="hover:underline">
                <h2 class="text-xs md:text-sm">reftecindustrialsupply@gmail.com</h2>
            </a>
        </div>
        <div class="flex gap-2 items-end justify-center">
            @svg("fluentui-mail-16", "w-4 h-4")
            <a href="mailto:reftec.indl@gmail.com" class="hover:underline">
                <h2 class="text-xs md:text-sm">reftec.indl@gmail.com</h2>
            </a>
        </div>
    </div>
</section>

<nav class="sticky shadow-md bg-white px-5 py-2 top-0 z-50 transition-all duration-300 ease-out transform scale-y-100 origin-top"
    id="main-navbar">
    <section class="max-w-6xl mx-auto">
        {{-- main nav --}}
        <section class="flex flex-wrap justify-between items-center mx-auto">
            {{-- Left --}}
            <a href="{{ false ? null : route('home') }}" class="flex items-center space-x-2 py-2">
                <img src="{{ asset('images/reftec_logo_notext.svg') }}" class="w-15 sm:w-20" alt="Logo" loading="lazy">
                <span class="p-0 m-0 font-semibold text-xs md:text-lg text-gray-800 font-castle uppercase">Industrial
                    Supply and <br class="block sm:hidden" /> Services Inc.</span>
            </a>

            {{-- Mobile Menu button --}}
            <section class="md:hidden">
                <button id="mobile-menu-toggle" class="p-2 rounded hover:bg-gray-200 cursor-pointer" title="menu">
                    @svg('fluentui-list-16', 'w-6 h-6 text-black')
                </button>
            </section>

            {{-- Right --}}
            <section class="hidden md:block">
                <ul class="flex space-x-2">
                    @php
                        $nav_links = [
                            ['name' => 'Home', 'route' => 'home'],
                            ['name' => 'Projects', 'route' => 'projects'],
                            ['name' => 'Products', 'route' => 'products'],
                            ['name' => 'About Us', 'route' => 'aboutus'],
                        ];
                    @endphp
                    @foreach ($nav_links as $link)
                        <li class="px-2 py-2">
                            <a href="{{ route($link['route']) }}"
                                class="{{ Route::currentRouteName() === $link['route'] ? 'font-bold text-accent-orange-300' : 'text-black font-regular' }} text-sm uppercase hover:font-bold">
                                {{ $link['name'] }}
                            </a>
                        </li>
                    @endforeach

                </ul>
            </section>
        </section>

        {{-- mobile nav --}}
        <section class="flex justify-center">
            {{-- Mobile Menu button --}}
            <section id="mobile-menu"
                class="flex-1 md:hidden hidden transition-all duration-300 ease-out transform -translate-y-4 opacity-0 pointer-events-none">
                <ul class="w-full flex flex-col">
                    @foreach ($nav_links as $link)
                        @if (Route::has($link['route']))
                            <li class="w-full px-4 py-2 text-center font-inter">
                                <a href="{{ route($link['route']) }}"
                                    class="{{ Route::currentRouteName() === $link['route'] ? 'font-bold text-accent-orange-300' : 'text-black font-regular' }} text-sm uppercase hover:font-bold">
                                    {{ $link['name'] }}
                                </a>
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
                    mobileMenu.classList.remove('-translate-y-4', 'opacity-0',
                        'pointer-events-none');
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
