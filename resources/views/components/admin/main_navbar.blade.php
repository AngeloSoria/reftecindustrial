<nav class="relative">
    {{-- Topbar --}}
    <section class="bg-brand-primary py-2 px-2 lg:px-6 flex shadow-lg font-inter">
        {{-- Menu control --}}
        <div class="px-4 flex items-center text-white gap-4 grow">
            <button aria-label="Toggle menu button" title="Toggle Menu"
                class="p-1 rounded transition-colors cursor-pointer">
                @svg('zondicon-menu', 'w-5 h-5')
            </button>

            {{-- Current view indicator --}}
            <div class="">
                <h2 class="text-lg font-medium">Dashboard</h2>
            </div>
        </div>

        {{-- Widgets --}}
        <div class="grow hidden md:flex items-center justify-end">

            {{-- Profile --}}
            <div class="relative group hover:bg-red-300/50 cursor-pointer">
                <div class="flex items-center justify-center gap-3">
                    <div class="text-white font-normal text-sm">
                        <span>TwentyLongCharacters (Super Admin)</span>
                    </div>
                    {{-- dropdown toggle icon --}}
                    <div>
                        <button class="text-white p-1">
                            @svg('tni-down', 'w-3 h-3')
                        </button>
                    </div>
                </div>

                {{-- popup --}}
                <div class="absolute top-full left-0 w-full bg-white rounded shadow-lg hidden group-hover:block">
                    <ul class="p-2 [&>*]:p-1 [&>*]:rounded-sm [&_*]:cursor-pointer [&>*]:hover:bg-gray-300 text-sm">
                        <li>
                            <a href="#" class="block w-full p-1">
                                <span class="flex items-center gap-1">
                                    @svg('bi-person', 'w-5 h-5')
                                    My Profile
                                </span>
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('user.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left p-1">
                                    <span class="flex items-center gap-1">
                                        @svg('css-log-out', 'w-5 h-5')
                                        Logout
                                    </span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </section>
</nav>
