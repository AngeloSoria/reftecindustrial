{{-- TODO: p, m dont work --}}
<nav class="shadow-md bg-white px-5 py-1 sticky top-0 z-50">
    <section class="max-w-7xl mx-auto">
        {{-- main nav --}}
        <section class="border flex flex-wrap justify-between items-center mx-auto">
            {{-- Left --}}
            <a href="{{ false ? null : route('home') }}" class="flex items-center space-x-2 py-2">
                <img src="{{ asset('images/reftec_logo_notext.svg') }}" class="w-22" alt="Logo">
                <span class="p-0 m-0 font-semibold text-xl text-gray-800 font-castle uppercase">Industrial Supply and Services Inc.</span>
            </a>

            {{-- Right --}}
            <section>
                
            </section>
        </section>
    </section>
</nav>
