<footer id="footer_" class="bg-cover bg-center relative border-t-4 border-accent-yellow"
    style="background-image: url('{{ asset('images/footerbg.jpg') }}');">
    <div class="block absolute top-0 left-0 w-full h-full bg-accent-black_2/75 z-0"></div>
    <img class="absolute bottom-3 right-0 opacity-50" src="{{ asset('images/reftec_logo_transparent.png') }}" />

    <section class="z-1 relative">
        <section class="px-4 py-10 flex gap-6 items-center justify-center flex-col md:flex-row">
            <x-googlemap class=""/>

            <div class="flex gap-4 flex-col align-center lg:flex-row">

                <div class="flex flex-col align-center justify-start md:align-start flex-1 text-white">
                    <p class="font-inter font-black text-lg">VISIT US</p>
                    <div class="mt-2">
                        <p class="text-xs">[ Main Office ]</p>
                        <div class="mt-2 flex flex-col justify-start">
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <x-heroicon-s-map-pin class="w-8 h-8 p-0 m-0 text-white" />
                                </div>
                                <a href="https://maps.app.goo.gl/WGAbyKPD9McargPf6" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                    <p class="text-sm">6001-C Tatalon St., Ugong Valenzuela City, Philippines</p>
                                </a>
                            </div>
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <x-heroicon-s-phone class="w-5 h-5 p-0 m-0 text-white" />
                                </div>
                                <p class="text-sm">+63 2 8961 4549</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2 opacity-50" />
                    <div>
                        <p class="text-xs">[ Satellite Offices ]</p>
                        <div class="mt-2 flex flex-col justify-start">
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <x-heroicon-s-map-pin class="w-8 h-8 p-0 m-0 text-white" />
                                </div>
                                <a href="https://maps.app.goo.gl/adGUc1M63rg3dNxYA" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                    <p class="text-sm">JSP Corporate Building, 4378 Dayap St., Palanan Makati City</p>
                                </a>
                            </div>
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <x-heroicon-s-phone class="w-5 h-5 p-0 m-0 text-white" />
                                </div>
                                <p class="text-sm">+63 2 7903 0836</p>
                            </div>
                        </div>
                        <div class="mt-2 flex flex-col justify-start">
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <x-heroicon-s-map-pin class="w-8 h-8 p-0 m-0 text-white" />
                                </div>
                                <p class="text-sm">Loberiza Subdivision, Poblacion Ilawod, Lambunao, Iloilo</p>
                            </div>
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <x-heroicon-s-phone class="w-5 h-5 p-0 m-0 text-white" />
                                </div>
                                <p class="text-sm">+63 33 533 7625</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col align-center justify-start md:align-start flex-1 text-white">
                    <p class="font-inter font-black text-lg">OUR SOCIALS & EMAILS</p>
                    <div class="mt-2">
                        <div class="flex items-center justify-start gap-2">
                            <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                <i data-lucide="facebook" class="w-6 h-6 fill-current text-white"></i>
                            </div>
                            <a href="https://www.facebook.com/ReftecIndustrialSupplyandServicesInc/" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                <p class="text-sm">ReftecIndustrialSupplyandServicesInc</p>
                            </a>
                        </div>
                        <div class="flex items-center justify-start gap-2">
                            <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                <x-heroicon-s-envelope class="w-8 h-8 p-0 m-0 text-white" />
                            </div>
                            <a href="mailto:reftecindustrialsupply@gmail.com" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                <p class="text-sm">reftecindustrialsupply@gmail.com</p>
                            </a>
                        </div>
                        <div class="flex items-center justify-start gap-2">
                            <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                <x-heroicon-s-envelope class="w-8 h-8 p-0 m-0 text-white" />
                            </div>
                            <a href="mailto:reftec.indl@gmail.com" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                <p class="text-sm">reftec.indl@gmail.com</p>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="flex flex-col align-center justify-start md:align-start flex-1 text-white">
                    <p class="font-inter font-black text-lg">QUICK LINKS</p>
                    <div class="mt-2">
                        <ul class="flex flex-col gap-2">
                            <li>
                                <a href="{{ route('home') }}" class="hover:underline text-sm">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('projects') }}" class="hover:underline text-sm">Projects</a>
                            </li>
                            <li>
                                <a href="{{ route('products') }}" class="hover:underline text-sm">Products</a>
                            </li>
                            <li>
                                <a href="{{ route('about_us') }}" class="hover:underline text-sm">About Us</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline text-sm">Admin Panel</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>


        </section>

        {{-- Credits --}}
        <section class="bg-brand-primary text-white py-4 font-inter font-medium text-center text-xs">
            <p>{{ env('APP_NAME') }} &copy; {{ date('Y') }}, All rights reserved.</p>
        </section>
    </section>
</footer>
